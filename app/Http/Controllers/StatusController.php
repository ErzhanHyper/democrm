<?php

namespace App\Http\Controllers;

use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $statuses = Status::all();
      return response()->json($statuses);
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
      $status = Status::create([
         'name' => request('name'),
         'message' => request('message'),
         'dtin' => Carbon::now(),
      ]);
      return response()->json($status);
   }

   /**
   * Display the specified resource.
   *
   * @param  \App\Status  $status
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
      $status = Status::find($id);
      return response()->json($status);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Status  $status
   * @return \Illuminate\Http\Response
   */
   public function edit(Status $status)
   {
      //
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Status  $status
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request,$id)
   {
      $status = Status::find($id);
      $name = $status->name;
      $message = $status->message;
      $mess_template = $status->mess_template;
      if(request('name') != null){
         $name = request('name');
      }
      if(request('message') != null){
         $message = request('message');
      }
      if(request('mess_template') != null){
         $mess_template = request('mess_template');
      }
      $status->update([
         'name' => $name,
         'message' => $message,
         'mess_template' => $mess_template,
      ]);

      return response()->json($status);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Status  $status
   * @return \Illuminate\Http\Response
   */
   public function destroy(Status $status)
   {
      //
   }
}
