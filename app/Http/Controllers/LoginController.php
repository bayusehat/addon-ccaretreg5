<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Hash;
use Str;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'admin.dashboard'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $username = $request->input('username');
            $password = $request->input('password');

            $check = DB::select("SELECT A.*,B.AREA,C.PROFILE FROM USERS A 
                                LEFT JOIN AREAS B ON A.CWITEL = B.CWITEL 
                                LEFT JOIN PROFILES C ON A.PROFILE_ID = C.ID
                                WHERE USERNAME = '$username'");

            if($check){
                // if($check[0]->deleted_at == null){
                    if(Hash::check($request->input('password'), $check[0]->password)){
                        $session = [
                            'id_user'  => $check[0]->id,
                            'username' => $check[0]->username,
                            'token'    => Str::random(60),
                            'profil'   => $check[0]->profile,
                            'witel'    => $check[0]->area,
                            'is_logged'=> true
                        ];
                        session($session);
                        return redirect('/dashboard');
                        // if(session('profil') == 'OPLANG'){
                        //     return redirect('/oplang');
                        // }else if(session('profil') == 'OBC'){
                        //     return redirect('/obc');
                        // }
                    }else{
                        return redirect()->back()->with('error','Password yang anda masukkan salah!');
                    }
                // }else{
                //     return redirect()->back()->with('error','User tidak aktif!');
                // }
            }else{
                return redirect()->back()->with('error','User tidak ditemukan');
            }
        }
    }

    public function doLogout()
    {
        Session::put('is_logged',false);
        Session::save();
        return redirect('/login');
    }

    public function tambah_user(Request $request)
    {
        $username = $request->input('username');
        $password = 'telkom135';

        DB::table('users')->insert([
            'username' => $username,
            'password' => Hash::make($password),
        ]);
    }
}
