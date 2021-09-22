<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class ProfilingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Profiling Treg5'
        ];

        return view('profiling',['data' => $data]);
    }

    public function register(Request $request)
    {
        $rules = [
            'nomor_inet' => 'required',
            'nama_pelanggan' => 'required',
            'disclaimer' => 'required',
            'hubungan' => 'required',
            'penanggung_jawab' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'nd_internet' => $request->input('nomor_inet'),
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'nomor_hp' => $request->input('nomor_hp'),
                'email_pelanggan' => $request->input('email_pelanggan'),
                'nomor_hp_alt' => $request->input('nomor_hp_alt'),
                'cwitel' => $request->input('cwitel'),
                'hubungan' => $request->input('hubungan'),
                'penanggung_jawab' => $request->input('penanggung_jawab')
            ];

            $insert = DB::connection('pgsql2')->table('profiling_new')->insert($data);

            if($insert){
                return redirect()->back()->with('success','Profiling berhasil diinput!');
            }else{  
                return redirect()->back()->with('error','Terjadi kesalahan! sila ulangi!');
            }
        }
    }

    public function getNumber(Request $request)
    {
        $nomor_hp = $request->input('nomor_hp');
        $query = DB::connection('pgsql2')->select("
            SELECT A.HP, B.* FROM HP A 
                LEFT JOIN PROFILING_MASTER B ON A.PROF_ID = B.ID
            WHERE A.HP = '$nomor_hp'
        ");
        
        if($query){
            return response([
                'status' => 200,
                'data' => $query[0]
            ]);
        }else{
            return response([
                'status' => 400,
                'message' => 'Nomor tidak ditemukan!'
            ]);
        }
    }

    //Admin

    public function dashboard(Request $request)
    {
        $data = [
            'title' => 'Profiling Dashboard',
            'content' => 'admin.profiling_admin'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::connection('pgsql2')->select("
            select * from profiling_new
        ");

        foreach ($query as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama_pelanggan, 
                $v->nomor_hp,
                $v->nd_internet,
                $v->email_pelanggan, 
                $v->penanggung_jawab,
                $v->hubungan
            ];
        }

        return response($response);
    }

    public function edit($id)
    {
        $query = DB::connection('pgsql2')->select("select * from where id = $id");
        $data = [
            'title' => 'Edit Profiling',
            'content' => 'admin.profiling_edit_admin',
            'data' => $query
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request)
    {
        //
    }
}
