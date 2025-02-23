<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Content;


class ApiController extends Controller
{
    public function heartBeat()
    {
        return response()->json(['status' => 'success', 'message' => 'Everything Up']);
    }

    public function getAllData()
    {
        // Queries for hadith, tags, and tag counts
        $hadithQuery = "
            SELECT contents.id, contents.title, contents.url, contents.ios_url, contents.approved,
                contents.posted, contents.created_at, contents.updated_at, contents.user_id,
                contents.thumb_url, contents.scheduled_at, contents.comment,
                DATE(posted_contents.created_at) as posted_at
            FROM contents
            INNER JOIN posted_contents ON contents.id = posted_contents.content_id
            ORDER BY posted_contents.created_at DESC";

        $tagItemsQuery = "SELECT id, tag FROM tags ORDER BY id";
        $tagCountsQuery = "SELECT tag_id, COUNT(*) AS num FROM posttags GROUP BY tag_id";

        // Cache query data
        $hadithItems = $this->cacheQueryData($hadithQuery);
        $tagItems = $this->cacheQueryData($tagItemsQuery);
        $tagCounts = $this->cacheQueryData($tagCountsQuery);

        // Optimize hadith data processing
        foreach ($hadithItems as $item) {
            // Format posted date
            $unixTimestamp = strtotime($item->posted_at . ' +1 day');
            $item->posted_at = date("l, F jS", $unixTimestamp);

            // Randomly assign iOS URL to URL if applicable
            if (!empty($item->ios_url) && rand(0, 1)) {
                $item->url = $item->ios_url;
            }

            // Use URL as thumb_url if thumb_url is empty
            $item->thumb_url = $item->thumb_url ?: $item->url;
        }

        // Create a tag count lookup
        $tagCountKey = [];
        foreach ($tagCounts as $tagCount) {
            $tagCountKey[$tagCount->tag_id] = $tagCount->num;
        }

        // Append counts to tag names
        foreach ($tagItems as $item) {
            if (isset($tagCountKey[$item->id])) {
                $item->tag .= " (" . $tagCountKey[$item->id] . ")";
            }
        }

        // Prepare the response
        $responseObj = [
            'hadith' => $hadithItems,
            'tags' => $tagItems,
        ];

        return json_encode($responseObj);
    }

    public function getTags()
    {
        // Query to get tags
        $tagsQuery = "SELECT id, tag FROM tags ORDER BY id";
        $tags = DB::select($tagsQuery);

        // Query to get tag counts
        $tagCountsQuery = "SELECT tag_id, COUNT(*) AS num FROM posttags GROUP BY tag_id";
        $tagCounts = DB::select($tagCountsQuery);

        // Map tag counts for quick lookup
        $tagCountKey = collect($tagCounts)->pluck('num', 'tag_id')->all();

        // Append counts to tags
        foreach ($tags as $tag) {
            if (isset($tagCountKey[$tag->id])) {
                $tag->tag .= " (" . $tagCountKey[$tag->id] . ")";
            }
        }

        // Return the result as JSON
        return response()->json(['items' => $tags]);
    }

    public function getPostTags(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer|exists:contents,id',
        ]);

        // Initialize variables
        $tagIds = [];
        $explanation = 0;

        // Fetch tags associated with the content
        $tags = DB::table('posttags')
            ->where('content_id', $request->id)
            ->pluck('tag_id');

        // Format the tag IDs
        foreach ($tags as $tagId) {
            $tagIds[] = ['id' => $tagId];
        }

        // Update content views and save
        $content = Content::findOrFail($request->id);
        $content->increment('views');

        // Log the view in `hadith_views`
        DB::table('hadith_views')->insert([
            'content_id' => $content->id,
        ]);

        // Check for explanation
        if (!empty($content->explaination)) {
            $explanation = 1;
        }

        // Return response as JSON
        return response()->json([
            'items' => $tagIds,
            'explanation' => $explanation,
        ]);
    }

    public function getPostTagsName(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer|exists:contents,id',
        ]);

        // Fetch tags associated with the content
        $tags = DB::table('posttags')
            ->join('tags', 'posttags.tag_id', '=', 'tags.id')
            ->where('posttags.content_id', $request->id)
            ->select('tags.id as id', 'tags.tag as name')
            ->get();

        // Update content views
        $content = Content::findOrFail($request->id);
        $content->increment('views');

        // Return response as JSON
        return response()->json([
            'items' => $tags,
        ]);
    }

    public function updateContentMetric(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|integer|exists:contents,id',
            'metric' => 'required'
        ]);


        // Check if the metric is valid
        if (!in_array($metric, ['downloads', 'shares'])) {
            return response()->json(['error' => 'Invalid metric'], 400);
        }

        // Update the specified metric
        $content = Content::findOrFail($request->id);
        $content->increment($metric);

        return response()->json(['message' => ucfirst($metric) . ' updated successfully']);
    }




    public function cacheQueryData(string $query, array $bindings = [], int $cacheDuration = 60): array
    {
        // Generate a unique cache key based on the query and bindings
        $cacheKey = md5($query . json_encode($bindings));

        // Check if the data is already cached
        return Cache::remember($cacheKey, $cacheDuration, function () use ($query, $bindings) {
            // Execute the query and return the result
            return DB::select($query, $bindings);
        });
    }


    public function getExplaination(Request $request)
    {
        $explaination = '';

        if ($request->id) {

            $content = content::where('id', '=', $request->id)->first();
            $explaination = $content->explaination;
        }

        return json_encode(array('explaination' => $explaination));
    }


    public function getAhadithOfCategory(Request $request)
    {
        $tagId = $request->id;

        // Fetch posts associated with the tag
        $items = DB::table('contents')
            ->join('posttags', 'contents.id', '=', 'posttags.content_id')
            ->where('posttags.tag_id', $tagId)
            ->select(
                'contents.id',
                'contents.title',
                'contents.url',
                'contents.ios_url',
                'contents.thumb_url',
                'contents.approved',
                'contents.posted',
                'contents.created_at',
                'contents.updated_at',
                'contents.user_id',
                'contents.scheduled_at',
                'contents.comment'
            )
            ->get();

        // Mark all retrieved items as "TAGGED" and optimize data handling
        foreach ($items as $item) {
            $item->comment = "TAGGED";
            $item->created_at = null;
            $item->updated_at = null;

            if (!empty($item->ios_url)) {
                $item->url = $item->ios_url;
            }

            if (empty($item->thumb_url)) {
                $item->thumb_url = $item->url;
            }
        }

        // Log the tag view
        DB::table('tag_views')->insert(['content_id' => $tagId]);

        return response()->json(['items' => $items->reverse()]);
    }
}
