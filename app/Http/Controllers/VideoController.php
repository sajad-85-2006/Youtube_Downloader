<?php

namespace App\Http\Controllers;

use App\Jobs\youtube;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        return response()->json(new VideoResource(Video::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function download(Request $request)
    {
        $tese = youtube::dispatch($request->link);
        return response()->json('Ok');
    }

}
