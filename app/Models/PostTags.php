<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $table = 'posttags';
    protected $with = ['tag'];
    public $timestamps = false;

    
    public function tag()
    {
        return $this->belongsTo(Tags::class, 'tag_id');
    }

    public function post()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    use HasFactory;
}
