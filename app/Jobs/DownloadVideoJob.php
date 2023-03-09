<?php

namespace App\Jobs;

use App\Models\Quality;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DownloadVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $link;

    public $type;


    public $quality;

    public $quality_list = ['144p' => 17, '360p' => 18, '720p' => 22];

    public $address_exe_file = 'D:\Programing\Projects\youtube\public\yt-dlp.exe';

    public function __construct($link, $type, $quality)
    {
        $this->link = $link;

        $this->type = $type;

        $this->quality = $quality;
    }

    public function handle()
    {
        //check status
        if ($this->type == 'youtube') {

            //Get Name Video
            $test = explode('v=', $this->link);
            exec('yt-dlp.exe -j ' . $this->link, $name_output);
            $obj = json_decode($name_output[0]);
            $time = $obj->duration_string;
            $name = $obj->_filename;
            $description = $obj->description;

            //save Video In Database
            Video::factory()->create(
                [
                    'name' => $name,
                    'caption' => $description,
                    'time' => $time
                ]
            );
            $id = Video::query()->orderByDesc('id')->first()['id'];

            //Download And Save Video
            foreach ($this->quality as $x) {
                $quality = '-f ' . Arr::get($this->quality_list, $x);
                $address_video = storage_path('\app\Video\\' . $test[1]) . '\\' . $name . $x . '.mp4';
                exec($this->address_exe_file . ' -o "' . $address_video . '" ' . $quality . ' ' . $this->link, $output, $re);

                //save Database
                Quality::factory()->create([
                    'quality' => $x,
                    'link_download' => $address_video,
                    'videos_id' => $id
                ]);
            }
        } else {
            //For other Status
            return Storage::disk('local')->put(now() . '/' . now() . '.mp4', file_get_contents($this->link));
        }
    }
}