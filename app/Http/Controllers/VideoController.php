<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoGetResource;
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
        $quality = $request->quality;
        youtube::dispatch($request->link, 'youtube', $quality);
        $value = Video::query()->orderByDesc('id')->first();
        $quality = Quality::query()->where('videos_id', $value['id'])->get();
        return response()->json(new VideoGetResource([$value, $quality]));

    }

}
