<?php

namespace App\Jobs;

use App\Mail\UserEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscribers;
    protected $title;
    protected $subject;
    public function __construct($subscribers,$title,$subject)
    {
        $this->subscribers = $subscribers;
        $this->title = $title;
        $this->subject = $subject;
    }


    public function handle()
    {
        foreach($this->subscribers as $sub){
            Mail::to($sub->email)->send(new UserEmail($this->title, $this->subject));
        }

    }
}
