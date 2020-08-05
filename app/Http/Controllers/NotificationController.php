<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class NotificationController extends Controller
{

   public function whatsapp($to, $message){
      $string = '';
      foreach ($message as $value) {
         $string .= $value->value."\n";
      }
      $sid = config('twilio.account_sid');
      $token = config('twilio.auth_token');
      $from = config('twilio.from');
      $client = new Client($sid, $token);
      foreach (json_decode($to) as $value) {
         $client->messages->create('whatsapp:'.$value->phone,[
            'from' => $from,
            'body' => $string
         ]);
      }
   }

}
