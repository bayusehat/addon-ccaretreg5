<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class StbController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'STB Tambahan',
            'data' =>  ''
        ];

        return view('stb_tambahan',$data);
    }

    public function register(Request $r)
    {
        $rules = [
            'nama_pelanggan' => 'required',
            'email_pelanggan' => 'required',
            'disclaimer' => 'required',
            'nomor_inet' => 'required'
        ];

        $isValid = Validator::make($r->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'nd_internet' => $r->input('nomor_inet'),
                'nama_pelanggan' => $r->input('nama_pelanggan'),
                'email_pelanggan' => $r->input('email_pelanggan'),
                'nomor_hp' => $r->input('nomor_hp'),
                'nomor_hp_alt' => $r->input('nomor_hp_alt'),
                'cwitel' => $r->input('cwitel')
            ];

            $insert = DB::table('stb_tambahan_new')->insert($data);

            if($insert){
                return redirect()->back()->with('success','Pendaftaran berhasil!');
            }else{
                return redirect()->back()->with('error','Terjadi kesalahan! pendaftaran gagal!');
            }
        }
    }

    public function getNumber(Request $request)
    {
        $nomor_hp = $request->input('nomor_hp');

        $query = DB::select(
            "SELECT A.HP, B.*, C.AREA FROM HP A 
                LEFT JOIN STB_TAMBAHAN_MASTER B ON A.ND_INTERNET = B.ND_INTERNET
                LEFT JOIN AREAS C ON B.CWITEL = C.CWITEL
            WHERE HP = '$nomor_hp'
            "
        );

        if($query){
           return response([
               'status' => 200,
               'data' => $query[0]
           ]);
        }else{
            return response([
                'status' => 500,
                'data' => [],
                'message' => 'Data tidak ditemukan!'
            ]);
        }
    }


    //Admin 
    public function dashboard()
    {
        $data = [
            'title' => 'STB Tambahan',
            'content' => 'admin.stb_tambahan_admin'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select * from stb_tambahan_new');

        foreach ($query as $i => $v) {
            $status = $v->status_oplang == NULL ? '<b><i>Belum di input</i></b>' : '<i>Sudah diinput</i>';
            $response['data'][] = [
                ++$i,
                $v->nama_pelanggan,
                $v->nomor_hp,
                $v->nd_internet,
                $status,
                date('d/M/Y H:i',strtotime($v->created)),
                '
                <a href="'.url('admin/stb/edit/'.$v->id).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Update</a>
                '
            ];
        }

        return response($response);
    }

    public function edit($id)
    {
        $query = DB::select('select A.*, b.username, c.area from stb_tambahan_new a left join users b on a.user_oplang=b.id
            left join areas c on a.cwitel = c.cwitel where a.id = '.$id);

        $data = [
            'title'=> 'Update STB Tambahan',
            'content' => 'admin.stb_tambahan_admin_edit',
            'data' =>  $query
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $query = DB::select('select A.*, b.username, c.area,d.agent from stb_tambahan_new a left join users b on a.user_oplang=b.id
            left join areas c on a.cwitel = c.cwitel
            left join code_agent d on a.cwitel = d.cwitel
            where a.id = '.$id);
        
        $rules = [
            'status_oplang' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'status_oplang' => $request->input('status_oplang'),
                'kcontact' => 'AOSF;'.$query[0]->agent.';BWA;'.$query[0]->nama_pelanggan.';'.$query[0]->nomor_hp.';STB TAMBAHAN;ENTRY 100K',
                'keterangan_oplang' => $request->input('keterangan_oplang'),
                'user_oplang' => session('id_user'),
                'created_oplang' => date('Y-m-d H:i:s')
            ];

            $insert = DB::table('stb_tambahan_new')->where('id',$id)->update($data);

            if($insert){ 
                return redirect('admin/stb')->with('success','Berhasil merubah data STB Tambahan!');
            }else{
                return redirect()->back()->with('error','Gagal merubah data STB Tambahan!');
            }
        }
    }
    
}
