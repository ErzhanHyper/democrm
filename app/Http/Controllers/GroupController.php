<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $groups = Group::all();
      $data = [];
      foreach ($groups as $value) {
         $data [] = [
            'id' => $value->id,
            'name' => $value->name,
            'permission' => [
               'read' => [
                  'name' => 'Чтение',
                  'status' => $value->read,
               ],
               'edit' => [
                  'name' => 'Редактирование',
                  'status' => $value->edit,
               ],
               'del' => [
                  'name' => 'Удаление',
                  'status' => $value->delete,
               ],
            ]
         ];
      }
      $groups = collect($data);
      return response()->json($groups);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {

   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $group = Group::create([
         'name' => request('name'),
         'read' => request('read'),
         'edit' => request('edit'),
         'delete' => request('del'),
      ]);
      return response()->json($group);
   }

   /**
   * Display the specified resource.
   *
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
   public function show(Group $group)
   {
      //
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
   public function edit(Group $group)
   {
      //
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, Group $group)
   {
      //
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Group  $group
   * @return \Illuminate\Http\Response
   */
   public function destroy(Group $group)
   {
      //
   }
}
