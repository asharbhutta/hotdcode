<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use DB;


class Content extends Model
{

    use HasFactory;

    protected $with = ['tags', 'post','views'];
    protected $guarded = [];

    public static function searchContent($request)
    {
        
        $routeName=Route::currentRouteName();
        
        $data = Content::where('approved', '<>', -1)
        ->Where('title', 'like', "%" . $request->input('title') . "%");
        if ($request->filled('approved')) {
            $data->Where('approved', '=', $request->input('approved'));
        }
        if ($request->filled('posted')) {
            $data->Where('posted', '=', $request->input('posted'));
        }
        if ($request->filled('explaination')) {
            $data->WhereNotNull('explaination');
        }
        if ($request->filled('tag')) {
            $posttags = PostTags::where('tag_id', '=', $request->input('tag'))->get();
            $postIds = [];
            foreach ($posttags as $pt) {
                $postIds[] = $pt->content_id;
            }

            $data->whereIn('id', $postIds);
        }
        if($routeName=="adminposted")
        {
            $data->where('posted','=',1);
            $postedIds = PostedContent::getRecentPostedContentIds();
            $data->whereNotIn('id', $postedIds);
            $data->orderBy('id', 'desc');
        }
        else if($routeName == "adminscheduled")
        {
            $data->where('posted', '=',0);
            $data->where('approved', '=',1);
            $data->orderBy('updated_at', 'desc');
        } 
        else if ($routeName == "admincustomscheduled") {
            $data->where('scheduled_at', '>',date("Y-m-d"));
            $data->orderBy('scheduled_at');
        }
        else
        {
            $data->orderBy('created_at', 'desc');
        }

        return $data->paginate(20);
    }

    public static function recentItems()
    {
        //$posts= self::with('post')->where('posted','=',1)->limit(7)->get();
            return Content::where('posted','=',1)
            ->join('posted_contents', 'contents.id', '=', 'posted_contents.content_id')
            ->orderBy('posted_contents.created_at','desc')
            ->select('contents.*')->limit(7) //see PS:
            ->get();

    }

    public function tags()
    {
        return $this->hasMany(PostTags::class,'content_id');
    }

    public function post()
    {
        return $this->hasOne(PostedContent::class,'content_id');
    }

    public function views()
    {
        return $this->hasMany(HadithViews::class, 'content_id');
    }
    
    public function getUrl()
    {
        if(!empty($this->thumb_url))
        return $this->thumb_url;
        else
        return $this->url;
    }

    public function getDate()
    {
        $routeName = Route::currentRouteName();
        if($routeName=="adminrecomended")
        {
            if (isset($this->scheduled_at)) {
                if (strtotime($this->scheduled_at) > strtotime("Y-m-d")) {
                    return "scheduled at:" . Carbon::parse($this->scheduled_at)->format('d/m/y');
                }
                return Carbon::parse($this->created_at)->format('d/m/y');
            }   
            return "Last Posted at:".$this->post->created_at->diffForHumans();
        }


        if(isset($this->updated_at) || isset($this->scheduled_at))
        {
            if (strtotime($this->scheduled_at) > strtotime(now())) {
                return "scheduled at:".Carbon::parse($this->scheduled_at)->format('d/m/y');
            }
            return "Created:".Carbon::parse($this->created_at)->format('d/m/y');
        }   
    }

    public function getPostTagIds()
    {
        $tagsArr=[];
        $tags=$this->tags;
        foreach($tags as $tg)
        {
            $tagsArr[]=$tg->tag_id;
        }

        return $tagsArr;
    }

    public static function recomendedItems()
    {
        //$posts= self::with('post')->where('posted','=',1)->limit(7)->get();
        $postedIds = PostedContent::getRecentPostedContentIds();
        return Content::where('posted', '=', 1)->where('approved', '=', 1)
            ->join('posted_contents', 'contents.id', '=', 'posted_contents.content_id')->whereNotIn('contents.id', $postedIds)
            ->orderBy('contents.views')
            ->orderBy('contents.shares')
            ->select('contents.*')->limit(10) //see PS:
            ->get();
    }


    public static function todayItemStats()
    {
        $items = DB::Select("Select hadith_views.content_id,contents.title, count(hadith_views.content_id) as views from hadith_views
        inner join contents on contents.id=hadith_views.content_id where DATE(hadith_views.created_at)=DATE(NOW()) 
        group by hadith_views.content_id,
        contents.title order by views desc ");
        $totalViews = 0;

        foreach ($items as $itm) {
            $totalViews = $totalViews + $itm->views;
        }

        $response = array('unique_items' => count($items), 'totalViews' => $totalViews, 'data' => $items,);
        return $response;
    }

    public function getScheduledTag()
    {

    }
}
