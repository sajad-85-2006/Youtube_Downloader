<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class youtube implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $link;

    public $type;

    public function __construct($link, $type)
    {
        $this->link = $link;

        $this->type = $type;
    }

    public function handle()
    {
        if ($this->type == 'youtube') {
            return Storage::disk('local')->put('test/image.mp4', file_get_contents($this->link));

        } else {
            return Storage::disk('local')->put('test/image.mp4', file_get_contents($this->link));

        }
    }
}
