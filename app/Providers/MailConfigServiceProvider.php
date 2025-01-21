<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $mail = DB::table('settings')->first();
            if ($mail) //checking if table is not empty
            {
                Config::set('mail.mailers.smtp.transport', $mail->mail_mailer);
                Config::set('mail.mailers.smtp.encryption', $mail->mail_encryption);
                Config::set('mail.mailers.smtp.host', $mail->mail_host);
                Config::set('mail.mailers.smtp.port', $mail->mail_port);
                Config::set('mail.mailers.smtp.username', $mail->mail_username);
                Config::set('mail.mailers.smtp.password', $mail->mail_password);
                Config::set('mail.from.address', $mail->mail_from_address);
                Config::set('mail.from.name', $mail->mail_from_name);
            }
        }
    }
}
