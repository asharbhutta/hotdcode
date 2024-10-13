<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class FirebaseTokens extends Model
{
    use HasFactory;

    public static function getTokenStats()
    {
        $today = self::whereDate('created_at', Carbon::today())->get();
        $thisWeek=self::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $thisMonth = self::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        $stats=[];
        $stats["today"]=$today->count();
        $stats["thisWeek"] = $thisWeek->count();
        $stats["thisMonth"] = $thisMonth->count();
        return $stats;
    }
}
