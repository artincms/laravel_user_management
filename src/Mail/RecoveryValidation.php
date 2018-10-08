<?php

namespace ArtinCMS\LUM\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecoveryValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $info;
    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->view('laravel_user_management::frontend.emails.password_resets')
            ->from('sadeghi@test.artincms.ir')
            ->subject('تایید ایمیل کاربر')
            ->with('info', $this->info);
    }
}
