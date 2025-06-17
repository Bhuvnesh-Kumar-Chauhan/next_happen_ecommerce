<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $detail)
    {
        $this->content = $content;
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->replaceContent();

        return $this->from(env('MAIL_FROM_ADDRESS'), $this->detail['app_name'])
                    ->subject('Reset Password')
                    ->view('admin.mailMessage')
                    ->with([
                        'content' => $this->content,
                    ]);
    }

    /**
     * Replace placeholders in the email content with actual values.
     */
    protected function replaceContent()
    {
        $data = ["{{user_name}}", "{{password}}", "{{app_name}}"];
        $this->content = str_replace($data, [$this->detail['user_name'], $this->detail['password'], $this->detail['app_name']], $this->content);
    }
}
