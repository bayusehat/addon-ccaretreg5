<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class OplangController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Oplang',
            'content' => 'oplang.oplang_view',
        ];
        
        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT A.*,B.USERNAME FROM UPSPEED_NEW A LEFT JOIN USERS B ON A.USER_OPLANG = B.ID ORDER BY CREATED,STATUS_OPLANG ASC");
        foreach ($query as $i => $v) {
            if($v->status_oplang == 1){
                $status = '<span class="badge badge-success">SUKSES by '.$v->username.'</span>';
            }else if($v->status_oplang == 2){   
                $status = '<span class="badge badge-warning">ANOMALI by '.$v->username.'</span>';
            }else if($v->status_oplang == 3){
                $status = '<span class="badge badge-danger">GAGAL by '.$v->username.'</span>';
            }else{
                $status = '<span class="badge badge-danger"><i>No Status</i></span>';
            }
            $response['data'][] = [
                ++$i,
                $v->nomor_inet,
                $v->nomor_hp,
                $v->nama_pelanggan,
                $status,
                date('d/m/Y H:i',strtotime($v->created)),
                '
                <a href="'.url('oplang/edit/'.$v->id_upspeed).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Update</a>
                '
            ];
        }

        return response($response);
    }

    public function edit($id)
    {
        $query = DB::select("SELECT A.*,B.USERNAME,c.AREA, D.PENAWARAN
        FROM UPSPEED_NEW A 
         LEFT JOIN USERS B ON A.USER_OPLANG = B.ID 
         LEFT JOIN AREAS C ON A.CWITEL = C.CWITEL
         LEFT JOIN UPSPEED_MASTER F ON A.NOMOR_INET = F.ND_INTERNET
         LEFT JOIN OFFERS D ON F.OFFER_ID = D.ID
         LEFT JOIN SPEEDS E ON D.SPEED_ID = E.ID
       WHERE ID_UPSPEED = $id");
        $data = [
            'title' => 'Edit Oplang',
            'data' => $query,
            'content' =>  'oplang.oplang_create'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'status_oplang' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'status_oplang' => $request->input('status_oplang'),
                'user_oplang' => session('id_user'),
                'keterangan_oplang' => $request->input('keterangan_oplang'),
                'created_oplang' => date('Y-m-d H:i:s')
            ];

            $update = DB::table('upspeed_new')->where('id_upspeed',$id)->update($data);

            if($update){
                return redirect()->back()->with('success','Berhasil memperbarui status dapros oleh Oplang');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui status');
            }
        }
    }
}
