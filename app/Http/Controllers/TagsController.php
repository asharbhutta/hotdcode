<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;


class TagsController extends Controller
{
    public function admin(Request $request)
    {
        //tests
        $tags = Tags::searchTags($request);
        return view('tags.admin')->with('data', $tags)->with('title', "Tags");
    }

    public function show($id)
    {
        $tag = Tags::findOrFail($id);
        if (!$tag->exists)
            return abort(404);


        return view('tags.show', [
            'tag' => $tag
        ]);
    }
}
