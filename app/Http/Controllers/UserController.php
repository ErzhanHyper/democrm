<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\GrpUser;
use Auth;
use DB;
use Image;
use Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

   public function getUsers(){
      $users = User::all();
      return response()->json($users);
   }

   public function getUser(){
      $user = User::find(Auth::user()->id);
      $user->grpuser->group;
      return $user;
   }

   public function getUserGrp(){
      $user = User::find(Auth::user()->id);
      $user = $user->grpuser->group;
      return $user;
   }



   public function update(Request $request){
      $user_id = request('user_id');
      $user = User::find($user_id);

      $photo = request('avatar');
      $photo_name = '';
      if ($photo != '') {
         $image = Image::make($photo);
         $mime = $image->mime();
         $extension = explode('/', $mime)[1];
         $path = "user_photo/" ;
         if (!is_writable(storage_path('public/'.$path))) {
            Storage::makeDirectory('public/'.$path, true);
         }
         $photo_name = "profile_photo_".substr(time(), 5) . "." . $extension;

         $image->save(storage_path('app/public/'.$path. "/" .$photo_name));
      }else{
         $photo_name = $user->avatar;
      }
      $name = $user->name;
      $Fio = $user->Fio;
      $phone = $user->phone;
      $email = $user->email;
      $status = $user->status;

      if(request('name') != ''){
         $name = request('name');
      }
      if(request('phone') != ''){
         $phone = str_replace([' ', '(', ')', '-'], '', request('phone'));
      }
      if(request('email') != ''){
         $email = request('email');
      }
      if(request('Fio') != ''){
         $Fio = request('Fio');
      }
      if(request('password') && $Fio != '' && $phone != '' && $name != ''){
         $status = "ACTIVE";
      }





      $user->update([
         'name' => $name,
         'Fio' => $Fio,
         'phone' => $phone,
         'email' => $email,
         'avatar' => $photo_name,
         'status' => $status,
      ]);

      $password = request('password');
      $password_confirmation = request('password_confirmation');
      $pass_message = '';
      $pass_status = false;

      if($password != ''){
         $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
         ]);
         $user->update([
            'password' => Hash::make($password),
         ]);
         if($user){
            $pass_status = true;
            $pass_message = 'Пароль успешно изменен';
         }
      }

      if($status == "ACTIVE"){
         $pass_status = true;
      }

      $data = [
         'user' => $user,
         'password' => [
            'message' => $pass_message,
            'status' => $pass_status
         ]
      ];

      return response()->json($data);


   }


   // public function change_password(Request $request){
   //    $user = Auth::user();
   //    $password = request('password');
   //    $password_confirmation = request('password_confirmation');
   //
   //    $this->validate($request, [
   //       'password' => ['required', 'string', 'min:8', 'confirmed'],
   //    ]);
   //
   //    $user->update([
   //       'password' => Hash::make($password),
   //    ]);
   //    $data = [
   //       'user' => $user,
   //       'message' => 'Пароль успешно изменен'
   //    ];
   //    return response()->json($data);
   // }


   public function show($id)
   {
      $data = User::find($id);

      return response()->json($data);
   }


   public function update_group(Request $request, $id){
      $group = GrpUser::where('user_id', $id)->get()['0'];
      $group = GrpUser::find($group->id);
      $group->update([
         'group_id' => request('group')
      ]);

      return $group;
   }

}
