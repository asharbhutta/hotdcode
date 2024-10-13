<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    public static function getTodayStats()
    {
        $stats=[];
        $models= self::orderBy('date','desc')->limit(7)->get();
        $stats["views"]=$models[0]->views - $models[1]->views;
        $stats["shares"] = $models[0]->shares - $models[1]->shares;
        $stats["downloads"] = $models[0]->downloads - $models[1]->downloads;

        return $stats;
    }

    public static function getTotalStats()
    {
        $models = self::orderBy('date', 'desc')->limit(1)->get();
        return $models[0];
    }
}
