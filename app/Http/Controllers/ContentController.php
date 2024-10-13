<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;
use App\Models\Tags;
use App\Models\Stat;
use App\Models\PostTags;
use App\Models\FirebaseTokens;
use App\Models\HadithViews;

class ContentController extends Controller
{
    public function test()
    {
        $date="2024-03-09";
        $contentIdArr=[185,193,188,187,204,287,191,192,207,248,244,270,279,975,205,186,215,272,284,287,197,241,547,283,237,198,1065,294,291,245,343];
        for($i=1; $i<31; $i++)
        {
            $cIndex= $contentIdArr[$i-1];
            $ramadanContent=Content::findOrFail($cIndex);
            $sDate= date('Y-m-d', strtotime('+'.$i.' day', strtotime($date)));
            // $ramadanContent->scheduled_at=$sDate;
            // $ramadanContent->save();

            echo $sDate." ". $ramadanContent->title."<br>";
        }

    }

    public function dashboard()
    {
        $recentItems = Content::recentItems();  
        $todayStats=Stat::getTodayStats();      
        return view('content.dashboard')
        ->with("recentItems", $recentItems)
        ->with('todayStats',$todayStats)
        ->with('totalStats',Stat::getTotalStats())
        ->with('appInstalls',FirebaseTokens::getTokenStats())
        ->with('todayViews',HadithViews::getTodayViews())->with('groupedStats',Content::todayItemStats());
    }

    public function admin(Request $request)
    {
        $data=Content::searchContent($request);
        return view('content.admin')->with("data",$data)->with("title","All Ahadith");
    }

    public function postedContent(Request $request)
    {
        $data = Content::searchContent($request);
        $mdata=['data'=>$data,'title'=>"Posted Content"];

        return view('content.admin')->with("data", $data)->with("title", "Posted Content");  
    }


    public function scheduled(Request $request)
    {
        Content::recentItems();
        $data = Content::searchContent($request);
        return view('content.list')->with("data", $data)->with("title", "Scheduled Items");
    }


    public function customscheduled(Request $request)
    {
        $data = Content::searchContent($request);
        return view('content.list')->with("data", $data)->with("title", "Custom Scheduled Items");
    }

    public function recomendedSchedule()
    {
        $data = Content::recomendedItems();
        return view('content.list')->with("data", $data)->with("title", "Recomended Items for Schedule");
    }

    public function storeSchedule()
    {
        $datesArr=self::getNextAvailableDates();
        $recomededPosts = Content::recomendedItems();
        $index=0;
        foreach($recomededPosts as $post)
        {
            $post->scheduled_at=$datesArr[$index];
            $post->save();
            $index++;
        }

        return  redirect('/admin/posts/recomended');        
    }

    public function resetSchedule()
    {
        $recomededPosts = Content::recomendedItems();
        foreach ($recomededPosts as $post) {
            $post->scheduled_at = null;
            $post->save();
        }

        return  redirect('/admin/posts/recomended');
    }

    public static function getNextAvailableDates()
    {
        $data = Content::where('scheduled_at', '<>', null)->orderBy('scheduled_at', 'desc')->get();
        $datesArr=[];
        $max_dates = 10;
        $countDates = 0;
        $startDate = date('d-m-Y', strtotime("+1 day", strtotime($data[0]->scheduled_at)));
        while ($countDates < $max_dates) {
            $NewDate = Date('Y-m-d', strtotime("+" . $countDates . " days", strtotime($startDate)));
            $datesArr[]=$NewDate;
            $countDates += 1;
        }

        return $datesArr;
    }

    public function show($id)
    {
        $post=Content::findOrFail($id);
        if(!$post->exists)
        return abort(404);

        
        return view('content.show', [
            'content' => $post
        ]);
    }

    public function edit($id)
    {
        $post = Content::findOrFail($id);
        $tags = Tags::getTagsArray();
        if (!$post->exists)
        return abort(404);
        return view('content.edit', [
            'content' => $post,
            'tags'=>$tags
        ]);
    }

    public function store(Request $request,$id)
    {
        $post = Content::findOrFail($id);
        if (!$post->exists)
        return abort(404);

        $validatedData = $request->validate([
            'title' => 'required',
            'approved' => 'required',
            'posted' => 'required',
            'url' => 'required',
            'comment'=>'max:1000',
            'scheduled_at'=>'max:1000',
            'explaination'=>'max:100000',
            'thumb_url'=>'max:1000',
            'ios_url'=>'max:1000'

            
        ]);
        $post->update($validatedData);

        PostTags::where('content_id', $id)
        ->delete();

        $tagsArr=$request->get('tags');
        if(!empty($tagsArr))
        {
            foreach ($tagsArr as $tg) {
                $postTag = new PostTags();
                $postTag->content_id = $post->id;
                $postTag->tag_id = $tg;
                $postTag->save();
            }
        }

        return  redirect('/admin/posts/admin');        
    }
    



    //
}
