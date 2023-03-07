<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Jobs\youtube;
use App\Models\Quality;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(new VideoResource(['video' => Video::all(), 'quality' => Quality::all()]));
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
