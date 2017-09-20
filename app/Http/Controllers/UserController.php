<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::where('id', $id)->get();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        /*
         * Ermittel avatar
         */
        $rvo = DB::table('ingredients')
            ->inRandomOrder()
            ->first();
        $input['avatar'] = $rvo->i_name;
        if ($rvo->i_selected > 0) {
            $input['avatar'] = $input['avatar'] . $rvo->i_selected;
        }
        $rvo->i_selected = $rvo->i_selected + 1;
        $rvoObject = json_decode(json_encode($rvo), true);
        $ingrVo = new Ingredient($rvoObject);
        $ingrVo->i_selected = $rvo->i_selected;
        $ingrVo->i_id = $rvo->i_id;
        $ingrVo->update();
        /*
         * Passwort aus 6 Buchstaben bilden
         *
         */
        $faker = Factory::create();
        $input['password'] = $faker->numberBetween(100000, 999999);
 /*
        $input['avatar'] = url('/') . '/' . $input['avatar'];
*/
        $request->replace($input);
        $this->validate($request, [
            //'avatar' => 'required|url|unique:user',
            'avatar' => 'required|unique:user',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();
        /*
         * Login über die App
         */
        $user = User::where('avatar', $input['avatar'])->first();
        if (!empty($user)) {
            if ($user['password'] == $input['password']) {
                return response()->json($user);
            } else {
                return response()->json(['status' => 'failed']);
            }
        } else {
            return response()->json(['status' => 'failed']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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
          /*
            'avatar' => 'required',
            'password' => 'required',
          */
          'jsonfav' => 'required',
            'lastsync' => 'required'
        ]);

        //$user->avatar = $request->avatar;
        $user->email = $request->email;
        //$user->password = $request->password;
        $user->jsonfav = $request->jsonfav;
        $date = new \DateTime($request->lastsync);
        $dd = $date->format('Y-m-d H:i:s');
        $user->lastsync = $dd;
        $user->save();
        return response()->json(['status' => 'success', 'id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (User::destroy($id)) {
            return response()->json(['status' => 'success']);
        }
    }
}
