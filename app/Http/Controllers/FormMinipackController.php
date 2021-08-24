<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class FormMinipackController extends Controller
{
    public function index()
    {
        // $get = DB::select("SELECT DISTINCT TRIM(SPEED) SPEED FROM MP_MASTER WHERE SPEED LIKE '%M%' ORDER BY SPEED ASC");
        // $data = [
        //     'title' => 'Minipack',
        //     'speed' => $get
        // ];

        // return view('form',$data);
        return view('form_minipack');
    }

    public function register(Request $request)
    {
        $rules = [
            'nomor_hp'        => 'required',
            'nomor_inet'      => 'required',
            'nama_pelanggan'  => 'required',
            'email_pelanggan' => 'required',
            'disclaimer'      => 'required'            
        ];

        $message = [
            'nomor_hp.required' => 'Field nomor hp harus diisi!',
            'nomor_inet.required' => 'Field nomor tidak boleh kosong!',
            'nama_pelanggan.required' => 'Field nama pelanggan tidak boleh kosong!',
            'email_pelanggan.required' => 'Field email pelanggan tidak boleh kosong!',
            'disclaimer.required' => 'Field disclaimer harus diisi!'
        ];

        $isValid = Validator::make($request->all(),$rules,$message);
        $query = DB::select("
            SELECT * FROM MP_NEW WHERE NOMOR_HP = '".$request->input('nomor_hp')."'"
        );
        if($query){
            return redirect()->back()->with('error','Pendaftaran gagal, nomor hanphone sudah terdaftar!');
        }else{
            if($isValid->fails()){
                return redirect()->back()->withInput()->withErrors($isValid->errors());
            }else{
                $data = [
                    'nomor_hp'        => $request->input('nomor_hp'),
                    'nomor_inet'      => $request->input('nomor_inet'),
                    'nama_pelanggan'  => $request->input('nama_pelanggan'),
                    'email_pelanggan' => $request->input('email_pelanggan'),
                    'addon'           => $request->input('addon'),
                    'price'           => $request->input('price'),
                    'cwitel'          => $request->input('cwitel'),
                    'nomor_hp_alt'    => $request->input('nomor_hp_alt'),
                    'kcontact'        => 'AOSF;SPXTH01;'.$request->input('nama_pelanggan').';'.$request->input('nomor_hp').';'.$request->input('addon').';selisih '.$request->input('price')
                ];

                $insert = DB::table('mp_new')->insert($data);

                if($insert){

                    return redirect()->back()->with('success','Pendaftaran berhasil!');
                }else{
                    return redirect()->back()->with('error','Terjadi kesalahan! pendaftaran gagal!');
                }
            }
        }
    }

    public function getNumber(Request $request)
    {
        $nomor_hp = $request->input('nomor_hp');

        $query = DB::select("
        SELECT A.*, B.ADDON, B.PRICE HARGA FROM(
            SELECT * FROM HP A LEFT JOIN MP_MASTER B ON A.ND_INTERNET = B.ND_INTERNET WHERE B.ND_INTERNET IS NOT NULL AND A.HP LIKE '%$nomor_hp%'
            ) A LEFT JOIN ADDONS B ON A.ADDON_ID = B.ID
        ");

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

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'content' => 'dashboard',
        ];

        return view('layout.index',['data' => $data]);
    }

    public function mola()
    {
        $data = [
            'title' => 'Cara berlangganan Mola',
            'content' => 'molaTV',
        ];

        return view('mola',['data' => $data]);
    }

    public function myih()
    {
        $data = [
            'title' => 'Cara Mapping MyIndihome',
            'content' => 'MyIndihome',
        ];

        return view('myindihome',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT * FROM MP_NEW");
        
        foreach ($query as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nama,
                $v->nomor_hp,
                $v->nomor_inet,
            ];
        }

        return response($response);
    }

    public function showuser()
    {
        $query = DB::select("SELECT * FROM MP_NEW");
        foreach ($query as $i => $v) {
            $update_kcontact = DB::table('mp_new')->where('id_mp',$v->id_mp)->update([
                'kcontact' => 'AOSF;SPXTH01;'.$v->nama_pelanggan.';'.$v->nomor_hp.';'.$v->addon.';selisih '.$v->price
            ]);
        }
    }
}
