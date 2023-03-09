<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoGetResource;
use App\Http\Resources\VideoResource;
use App\Jobs\DownloadVideoJob;
use App\Jobs\youTubeDownload;
use App\Models\Quality;
use App\Models\Video;

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
    public function download(VideoRequest $request)
    {
        $quality = $request->quality;

        //Run Job
        DownloadVideoJob::dispatch($request->link, 'youtube', $quality);

        //get insert Data From Databases
        $value = Video::query()->orderByDesc('id')->first();
        $quality = Quality::query()->where('videos_id', $value['id'])->get();

        return response()->json(new VideoGetResource([$value, $quality]));

    }

}
