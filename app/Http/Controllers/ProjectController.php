<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use App\GrpUser;
use App\JrnStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\NotificationController;

class ProjectController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $projects = Project::all();
      $projects_arr = [];
      foreach ($projects as $value) {
         $projects_arr[] = [
            'id' => $value->id,
            'name' => $value->name,
            'dtin' => Carbon::parse($value->dtin)->format('Y-m-d H:m'),
            'owner' => $value->user['Fio'],
            'client' => $value->client['name'],
            'status' => $value->statuses['name']
         ];
      }

      return response()->json($projects_arr);
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

      $this->validate($request, [
         'name' => ['required'],
         'owner' => ['required'],
      ]);

      $project = Project::create([
         'name' => request('name'),
         'description' => request('description'),
         'owner' => request('owner'),
         'collaborators' => json_encode(request('collaborators')),
         'status' => 1,
         'dtin' => Carbon::now(),
         'client_id' => request('client'),
         // 'tasks' => json_encode(request('tasks')),
      ]);

      $data = [
         'message' => 'Проект '.$project->name.' успешно добавлен',
         'project' => $project
      ];

      return response()->json($data);
   }

   /**
   * Display the specified resource.
   *
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $data = Project::find($id);
      $tasks = $data->task;
      foreach ($tasks as $value) {
         $value->user['Fio'];
      }
      return response()->json($data);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function edit(Project $project)
   {
      //
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
      $project = Project::find($id);
      $status = $project->status;
      if($project->status != request('status')){
         $status = request('status');
      }
      $old_status = $project->status;
      $project->name = request('name');
      $project->description = request('description');
      $project->owner = request('owner');
      $project->collaborators = json_encode(request('collaborators'));
      $project->status = $status;
      $project->dtin = Carbon::now();
      $project->client_id = request('client');
      $project->save();
      $message = [];
      if($project && $old_status != $project->status){
         foreach (json_decode($project->statuses['mess_template']) as $value) {
            if($value->name == 'project'){
               $value->value = $project->name;
            }
            if($value->name == 'owner'){
               $value->value = $project->user->Fio;
            }

            $message[]= $value;

         }
         $to = $project->client->phone;
         $notify = new NotificationController;
         $notify->whatsapp($to, $message);
         JrnStatus::create([
            'status' => $project->statuses->name,
            'project_id' => $project->id
         ]);

      }

      $data = [
         'phones' => $to,
         'message' => 'Проект '.$project->name.' успешно обновлен',
         'project' => $project
      ];


      return response()->json($data);

   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Project  $project
   * @return \Illuminate\Http\Response
   */
   public function destroy(Project $project)
   {
      //
   }
}
