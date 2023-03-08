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

class youtube implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $link;

    public $type;


    public $quality;


    public function __construct($link, $type, $quality)
    {
        $this->link = $link;

        $this->type = $type;

        $this->quality = $quality;
    }

    public function handle()
    {
        if ($this->type == 'youtube') {
            $qu = ['144p' => 17, '360p' => 18, '720p' => 22];
            $test = explode('v=', $this->link);
            exec('yt-dlp.exe --get-filename ' . $this->link, $name_output);
            $name = explode('.w', $name_output[0])[0];
            Video::factory()->create(
                [
                    'name' => $name,
                ]
            );
            $id = Video::query()->orderByDesc('id')->first()['id'];

            foreach ($this->quality as $x) {
                $quli = '-f ' . Arr::get($qu, $x);
                $addr = storage_path('\app\Video\\' . $test[1]) . '\\' . $name . $x . '.mp4';
                exec('yt-dlp.exe  -o "' . $addr . '" ' . $quli . ' ' . $this->link, $output, $re);
                Quality::factory()->create([
                    'quality' => $x,
                    'link_download' => $addr,
                    'videos_id' => $id
                ]);
            }
        } else {
            return Storage::disk('local')->put('test/image.mp4', file_get_contents($this->link));

        }
    }
}
