<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class ObcController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data OBC',
            'content' => 'obc.obc_view'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function edit($id)
    {
        $query = DB::select("SELECT A.*,B.USERNAME,C.USERNAME USER_OBC,D.AREA,G.PENAWARAN 
                FROM UPSPEED_NEW A 
                    LEFT JOIN USERS B ON A.USER_OPLANG = B.ID 
                    LEFT JOIN USERS C ON A.USER_OBC = C.ID 
                    LEFT JOIN AREAS D ON A.CWITEL = D.CWITEL 
                    LEFT JOIN UPSPEED_MASTER F ON A.NOMOR_INET = F.ND_INTERNET
                    LEFT JOIN OFFERS G ON F.OFFER_ID = G.ID
                    LEFT JOIN SPEEDS E ON G.SPEED_ID = E.ID
                WHERE ID_UPSPEED = $id");
        $data = [
            'title' => 'Edit OBC',
            'data' => $query,
            'content' =>  'obc.obc_create'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT A.*,B.username,C.username user_obc FROM UPSPEED_NEW A LEFT JOIN USERS B ON A.USER_OPLANG = B.ID LEFT JOIN USERS C ON A.USER_OBC = C.ID WHERE USER_OPLANG IS NOT NULL ORDER BY CREATED_OPLANG,STATUS_OBC");
        foreach ($query as $i => $v) {
            if($v->status_oplang == 1){
                $status = '<span class="badge badge-success">SUKSES by '.$v->username.'</span>';
            }else if($v->status_oplang == 2){   
                $status = '<span class="badge badge-warning">ANOMALI by '.$v->username.'</span>';
            }else{
                $status = '<span class="badge badge-danger">GAGAL by '.$v->username.'</span>';
            }

            if($v->status_obc == 1){
                $status_obc = '<span class="badge badge-success">CALLED by '.$v->user_obc.'</span>';
            }else if($v->status_obc == 2){
                $status_obc = '<span class="badge badge-danger">RNA by '.$v->user_obc.'</span>';
            }else{
                $status_obc = '<span><i>No Status</i></span>';
            }

            $response['data'][] = [
                ++$i,
                $v->nomor_inet,
                $v->nomor_hp,
                $v->nama_pelanggan,
                $status,
                $status_obc,
                date('d/m/Y H:i',strtotime($v->created_oplang)),
                '
                <a href="'.url('obc/edit/'.$v->id_upspeed).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Update</a>
                '
            ];
        }

        return response($response);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'status_obc' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'status_obc' => $request->input('status_obc'),
                'user_obc' => session('id_user'),
                'keterangan_obc' => $request->input('keterangan_obc'),
                'created_obc' => date('Y-m-d H:i:s')
            ];

            $update = DB::table('upspeed_new')->where('id_upspeed',$id)->update($data);

            if($update){
                return redirect()->back()->with('success','Berhasil memperbarui status dapros oleh OBC');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui status');
            }
        }
    }
}
