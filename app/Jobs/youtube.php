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

    /**
     * Create a new job instance.
     */
    public $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        return Storage::disk('local')->put('test/image.mp4', file_get_contents($this->link));
    }
}
