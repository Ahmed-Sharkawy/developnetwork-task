<?php

namespace App\Jobs\Api;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeletePostsMoreThanThirtyDays implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $posts = Post::select('id')->whereNotNull('deleted_at')->get();

        foreach ($posts as $post) {
            $months = Carbon::now()->diffInMonths($post->deleted_at);

            if ($months) {
                $post->delete();
            }

        }
    }
}
