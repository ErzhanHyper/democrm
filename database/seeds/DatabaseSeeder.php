<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
   /**
   * Seed the application's database.
   *
   * @return void
   */
   public function run()
   {
      // $this->call(UserSeeder::class);

      DB::table('statuses')->insert([
         [
            "id"=> 1,
            "name"=> "Новая",
            'dtin' => Carbon::now(),
         ],
         [
            "id"=> 2,
            "name"=> "Выполнено",
            'dtin' => Carbon::now(),
         ],
         [
            "id"=> 3,
            "name"=> "Не выполнено",
            'dtin' => Carbon::now(),
         ],
      ]);

      DB::table('groups')->insert([
         [
            "name"=>"Администратор",
            'edit' => 1,
            'read' => 1,
            'delete' => 1,
         ],

         [
            "name"=>"Пользователь",
            'edit' => 0,
            'read' => 1,
            'delete' => 0,
         ],
      ]);

      DB::table('grp_users')->insert([
         [
            "group_id"=>1,
            "user_id"=>1,
         ],
      ]);

      DB::table('users')->insert([
         [
            'email' => 'erzhan.hype@gmail.com',
            'phone' => '+77085943448',
            'password' => bcrypt('password'),

            'status' => "ACTIVE",
            'name' => 'Admin',
            'Fio' => 'Admin',
         ],
      ]);

   }
}
