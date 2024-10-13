<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';


    public static function getTagsArray()
    {
        $tagsArr=[];
        $tags=self::orderBy("tag","asc")->get();
        foreach($tags as $tg)
        {
            $tagsArr[$tg->id]=$tg->tag;
        }
        return $tagsArr;
    }

    public static function searchTags($request)
    {

        $data = Tags::Where('tag', 'like', "%" . $request->input('tag') . "%");
        return $data->paginate(20);
    }

    public function posts()
    {
        return $this->hasMany(PostTags::class, 'tag_id');
    }

    use HasFactory;
}
