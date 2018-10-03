<?php

namespace ArtinCMS\LUM\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $info;
    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->view('laravel_user_management::frontend.emails.new_user_validation')
            ->from('sanat@freezones.ir')
            ->subject('تایید ایمیل کاربر')
            ->with('info', $this->info);
    }
}
