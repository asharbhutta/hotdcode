<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HadithViews extends Model
{
    protected $table = 'hadith_views';
    use HasFactory;

    public static function getTodayViews()
    {
        return self::whereDate('created_at', Carbon::today())->paginate(20);
    }

    public function post()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
