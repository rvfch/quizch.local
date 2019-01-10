<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->isMethod('put') ? User::findOrFail($request->id) : '';


        $user->name = $request->input('name') != '' ? $request->input('name') : $user->name;

        if($request->input('password') != '') {
          if(Hash::check($request->input('oldPassword'), $user->password)) {
            $user->password = Hash::make($request->input('password'));
          }
          else {
            return response()->json('ERROR_OLD_PASSWORD');
          }
        }



        if($user->save())
          return response()->json('OK');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
