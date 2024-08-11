<?php

namespace App\Jobs;

use App\Events\MessageSent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public User $receiver;
    public User $sender;
    public string $message;


    /**
     * Create a new job instance.
     */
    public function __construct(User $receiver, User $sender, string $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        broadcast(new MessageSent($this->receiver->id, $this->sender->id, $this->message));
    }
}
