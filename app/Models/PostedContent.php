<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostedContent extends Model
{
    protected $table = 'posted_contents';
    use HasFactory;

    public static function getRecentPostedContentIds()
    {
        $ids=[];
        $models=self::orderBy('id', 'desc')->limit(60)->get();
        foreach($models as $mdl):
            $ids[]=$mdl->content_id;
        endforeach;

        return $ids;
    }
}
