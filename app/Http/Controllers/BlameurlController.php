<?php

namespace App\Http\Controllers;

use App\Blameurl;

class BlameurlController extends Controller
{
    public function getBlameurls()
    {
        $articles  = Blameurl::all();
        return response()->json($articles);
    }

    public function getBlameurl($id)
    {
        $article  = Blameurl::find($id);
        return response()->json($article);
    }

    public function saveBlameurl(Request $request)
    {
        $article = Blameurl::create($request->all());
        return response()->json($article);
    }

    public function deleteBlameurl($id)
    {
        $article  = Blameurl::find($id);
        $article->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function updateBlameurl(Request $request, $id)
    {
        $article  = Blameurl::find($id);
        $article->blameurl = $request->input('blameurl');
        $article->save();
        return response()->json($article);
    }}
