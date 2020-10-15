<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TOTAL_EMAILS = 1000;
    const MAX_EMAILS_PER_MINUTE = 100;

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
        // Mailtrap is too slow, change to gmail if needed
        $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
            ->setUsername('123d98857d300b')
            ->setPassword('85ee5a8cdd86ea')
        ;

        $mailer = new Swift_Mailer($transport);

        $mailer->registerPlugin(new \Swift_Plugins_ThrottlerPlugin(
            static::MAX_EMAILS_PER_MINUTE, \Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE
        ));

        // Sending the same email just for testing
        $message = (new Swift_Message())
            ->setSubject('Test 1000 emails')
            ->setFrom(['support@example.com'])
            ->setTo(['newuser@example.com' => 'New Mailtrap user']);

        for ($i = 1; $i <= static::TOTAL_EMAILS; $i++) {
            $mailer->send( $message );
        }
    }
}
