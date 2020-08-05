<?php

namespace App\Http\Controllers;

use App\Client;

use Illuminate\Http\Request;
use DB;
use Image;
use Storage;

class ClientController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $clients = Client::all();
      $clients_arr = [];
      foreach ($clients as $value) {
         $phone_arr = [];
         $email_arr = [];

         foreach (json_decode($value->phone) as $phone){
            $phone_arr[] = $phone;
         }
         foreach (json_decode($value->email) as $email){
            $email_arr[] = $email;
         }
         $clients_arr[] = [
            'id' => $value->id,
            'name' => $value->name,
            'person' => $value->person,
            'phone' => $phone_arr,
            'email' => $email_arr,
            'photo' => $value->photo,
         ];
      }



      return response()->json($clients_arr);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
      //
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {

      $phone = [];
      $email = [];
      foreach (json_decode(request('phone'), true) as $value) {
         $phone[] = [
            'phone' => $value['phone']
         ];
      }

      foreach (json_decode(request('email'), true) as $value) {
         $email[] = [
            'email' => $value['email']
         ];
      }

      $photo = request('file');
      $photo_name = '';
      if ($photo != '') {
         $image = Image::make($photo);
         $mime = $image->mime();
         $extension = explode('/', $mime)[1];
         $path = "clients/photo/" ;
         if (!is_writable(storage_path('public/'.$path))) {
            Storage::makeDirectory('public/'.$path, true);
         }
         $photo_name = "photo_".substr(time(), 5) . "." . $extension;

         $image->save(storage_path('app/public/'.$path. "/" .$photo_name));
      }else{
         $photo_name = null;
      }


      $client = Client::create([
         'name' => request('name'),
         'person' => request('person'),
         'phone' => json_encode($phone),
         'email' => json_encode($email),
         'photo' => $photo_name,
      ]);


      return response()->json($client);
   }

   /**
   * Display the specified resource.
   *
   * @param  \App\Client  $client
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $data = Client::find($id);

      return response()->json($data);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Client  $client
   * @return \Illuminate\Http\Response
   */
   public function edit(Client $client)
   {
      //
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Client  $client
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, Client $client)
   {
      //
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Client  $client
   * @return \Illuminate\Http\Response
   */
   public function destroy(Client $client)
   {
      //
   }
}
