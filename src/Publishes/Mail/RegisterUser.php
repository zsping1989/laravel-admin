<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterUser extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $url;
    /**
     * 最大连接数
     * The number of times the job may be attempted.
     * @var int
     */
    public $tries = 3;

    /**
     * 超时时长
     * @var int
     */
    public $timeout = 15;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('用户激活')
            ->markdown('emails.register')
            ->with([
                'user'=>$this->user->toArray(),
                'url'=>$this->url
            ]);
    }
}
