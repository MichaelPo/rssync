<?php

namespace App\Http\Controllers;

use App\User;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::where('id', $id)->get();
        if(!empty($user['avatar'])){
            return response()->json($user);
        }
        else{
            return response()->json(['status' => 'fail']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['avatar'] = url('/').'/'.$input['avatar'];
        $request->replace($input);

        $this->validate($request, [
            'avatar' => 'required|url|unique:user',
            'password' => 'required|min:6',
            'jsonfav' => 'required',
            'lastsync' => 'required'
        ]);

        $user = new User();
        $user->avatar = $request->avatar;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->jsonfav = $request->jsonfav;
        $date = new \DateTime($request->lastsync);
        $dd = $date->format('Y-m-d');
        $user->lastsync = $dd;
        $user->save();
        return response()->json($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => 'Avatar nicht bekannt']);
        }
        //
        $this->validate($request, [
            'avatar' => 'required',
            'password' => 'required',
            'jsonfav' => 'required',
            'lastsync' => 'required'
        ]);

        $user = new User();
        $user->avatar = $request->avatar;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->jsonfav = $request->jsonfav;
        $date = new \DateTime($request->lastsync);
        $dd = $date->format('Y-m-d');
        $user->lastsync = $dd;
        $user->save();
        return response()->json(['status' => 'success', 'id' => $user->id]);
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
        if(User::destroy($id)){
            return response()->json(['status' => 'success']);
        }
    }
}
