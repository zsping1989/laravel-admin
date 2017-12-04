<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('找回密码')
            ->markdown('emails.forgot_password')
            ->with([
                'user'=>$this->user->toArray(),
                'code'=>$this->code
            ]);
    }
}
