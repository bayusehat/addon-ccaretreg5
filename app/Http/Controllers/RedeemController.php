<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Str;

class RedeemController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Redeem Point',
            'pekerjaan' => DB::select('select * from redeem_pekerjaan')
        ];

        return view('redeem',$data);
    }

    public function register(Request $request)
    {
        $rules = [
            'nomor_hp' => 'required',
            'nomor_inet' => 'required',
            'nama_pelanggan' => 'required',
            'contact_person' => 'required',
            'alamat_pelanggan' => 'required',
            'alamat_pengiriman' => 'required',
            'email_pelanggan' => 'required',
            'pekerjaan_pelanggan' => 'required',
            'tgl_lahir_pelanggan' => 'required',
            'kode_voucher' => 'required'
            // 'disclaimer' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $nd = $request->input('nomor_inet');
            $q_check = DB::select("select count(*) nomor from redeem_new where nd_internet = '$nd'");
            // if(count($q_check)<=0){
                $data = [
                    'nomor_hp' => $request->input('nomor_hp'),
                    'nd_internet' => $request->input('nomor_inet'),
                    'nama_pelanggan' => $request->input('nama_pelanggan'),
                    'contact_person' => $request->input('contact_person'),
                    'alamat_pelanggan' => $request->input('alamat_pelanggan'),
                    'alamat_pengiriman' => $request->input('alamat_pengiriman'),
                    'pekerjaan_pelanggan' => $request->input('pekerjaan_pelanggan'),
                    'tgl_lahir_pelanggan' => $request->input('tgl_lahir_pelanggan'),
                    'email_pelanggan' =>  $request->input('email_pelanggan'),
                    'cwitel' => $request->input('cwitel'),
                    'kode_voucher' => $request->input('kode_voucher')
                ];
    
                $insert = DB::table('redeem_new')->insertGetId($data);
    
                if($insert){
                    return redirect()->back()->with('success','Redeem point berhasil!');
                }else{
                    return redirect()->back()->with('error','Terjadi kesalahan, redeem point gagal!');
                }
            // }else{
            //     return redirect()->back()->with('error','Nomor sudah terdaftar!');
            // }
        }
    }

    public function getNumber(Request $request)
    {
        $nomor_hp = $request->input('nomor_hp');

        $query = DB::select(
            "SELECT A.HP,B.*,C.NOMOR_WA, C.NAMA_AGEN_CX, C.LINK , D.AREA
                FROM HP A LEFT JOIN REDEEM_MASTER B ON A.ND_INTERNET = B.ND_INTERNET
                LEFT JOIN REDEEM_AGEN C ON B.CWITEL = C.CWITEL
                LEFT JOIN AREAS D ON B.CWITEL = D.CWITEL
            WHERE A.HP = '$nomor_hp' AND B.ND_INTERNET IS NOT NULL
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

    public function dashboard(Request $request)
    {
        $data = [
            'title' => 'Redeem Point My Indihome Inbox',
            'content'=> 'admin.redeem_admin',
            'witel' =>  DB::select('select * from areas')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $witel = $request->input('witel');
        if($witel){
            $cwitel = "a.cwitel = $witel";
        }else{
            $cwitel = "1=1";
        }
        $response['data'] = [];
        $query =  DB::select("select a.*,b.area from redeem_new a left join areas b on a.cwitel = b.cwitel where $cwitel");
        foreach ($query as $i => $v) {
            if($v->attachment == '' || $v->attachment == null){
                $status = '<b><i>Bukti pengiriman belum diupload</i></b>';
            }else{
                $status = '<i>Bukti pengiriman sudah diupload</i>';
            }
            $response['data'][] = [
                ++$i,
                $v->nama_pelanggan,
                $v->nomor_hp,
                $v->nd_internet,
                $v->email_pelanggan,
                $v->alamat_pengiriman,
                $v->area,
                $status,
                date('d/m/Y H:i',strtotime($v->created)),
                '<a href="'.url('admin/redeem/edit/'.$v->id).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Upload bukti pengiriman</a>'
            ];
        }

        return response($response);
    }

    public function edit($id)
    {
        $query = DB::select("select a.*,b.area from redeem_new a left join areas b on a.cwitel = b.cwitel where a.id = $id");

        $data = [
            'title' => 'Upload bukti pengiriman',
            'content' => 'admin.redeem_edit_admin',
            'data' => $query
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'attachment' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            if($request->has('attachment')){
                $f = $request->file('attachment');
                $name = Str::random(10).$f->getClientOriginalName();
                $f->move(public_path('/backend/img'),$name);
                
                $upatt = DB::table('redeem_new')->where('id',$id)->update([
                    'attachment' => $name
                ]);

                if($upatt){
                    return redirect('admin/redeem')->with('success','Berhasil mengupload bukti pengiriman');
                }else{
                    return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan!');
                }
            }else{
                return redirect()->back()->with('error','Terjadi kesalahan saat mengupload, sila coba lagi!');
            }
        }
    }
}
