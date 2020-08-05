<?php

namespace App\Mail\Auth;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
   use Queueable, SerializesModels;

   public $user;

   public $password;
   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, $password)
   {
      $this->user = $user;
      $this->password = $password;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build()
   {
      // return $this->markdown('emails.auth.registration');
      return $this->markdown('emails.auth.registration')
            ->subject(config('app.name') . ": Registration Notification")
            ->from(config('mail.from.address'));
   }
}
