<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class FormController extends Controller
{
    public function index()
    {
        $getSpeed = DB::select("SELECT DISTINCT TRIM(SPEED) SPEED FROM UPSPEED_MASTER WHERE SPEED LIKE '%M%' ORDER BY SPEED ASC");
        $data = [
            'title' => 'Upgrade Speed',
            'speed' => $getSpeed
        ];

        return view('form',$data);
    }

    public function register(Request $request)
    {
        $rules = [
            'nomor_hp'        => 'required',
            'nomor_inet'      => 'required',
            'nama_pelanggan'  => 'required',
            'email_pelanggan' => 'required',
            'up_to_speed'     => 'required',
            'cur_speed'       => 'required',
            'disclaimer'      => 'required'            
        ];

        $message = [
            'nomor_hp.required' => 'Field nomor hp harus diisi!',
            'nomor_inet.required' => 'Field nomor tidak boleh kosong!',
            'nama_pelanggan.required' => 'Field nama pelanggan tidak boleh kosong!',
            'email_pelanggan.required' => 'Field email pelanggan tidak boleh kosong!',
            'cur_speed.required' => 'Field kecepatan saat ini tidak boleh kosong!',
            'up_to_speed.required' => 'Field upgrade kecepatan harus diisi!',
            'disclaimer.required' => 'Field disclaimer harus diisi!'
        ];

        $isValid = Validator::make($request->all(),$rules,$message);
        $query = DB::select("
            SELECT * FROM UPSPEED_NEW WHERE NOMOR_HP = '".$request->input('nomor_hp')."'"
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
                    'up_to_speed'     => $request->input('up_to_speed'),
                    'cur_speed'       => $request->input('cur_speed'),
                    'price'           => $request->input('price'),
                    'cwitel'          => $request->input('cwitel'),
                    'nomor_hp_alt'    => $request->input('nomor_hp_alt'),
                    'nama_paket'      => $request->input('nama_paket'),
                    'kcontact'        => 'AOSF;SPXTH01;'.$request->input('nama_pelanggan').';'.$request->input('nomor_hp').';'.$request->input('up_to_speed').';selisih '.$request->input('price')
                ];

                $insert = DB::table('upspeed_new')->insert($data);

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
        SELECT A.*, B.PENAWARAN, C.SPEED_S UP_SPEED, B.PRICE + A.HARGA_ADDON - A.ABONEMEN HARGA FROM(
            SELECT A.*,B.*,C.ADDON, CASE WHEN C.PRICE IS NOT NULL THEN C.PRICE ELSE 0 END HARGA_ADDON FROM HP A 
                LEFT JOIN UPSPEED_MASTER B ON A.ND_INTERNET = B.ND_INTERNET
                LEFT JOIN ADDONS C ON B.ADDON_ID = C.ID 
                WHERE B.ND_INTERNET IS NOT NULL AND A.HP LIKE '%$nomor_hp%'
        ) A LEFT JOIN OFFERS B ON A.OFFER_ID = B.ID
            LEFT JOIN SPEEDS C ON B.SPEED_ID = C.ID
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

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT * FROM UPSPEED_NEW");
        
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

    public function kcontactPage()
    {
        $data = [
            'title' => 'Generate KCONTACT',
            'content' => 'admin.generate_kcontact',
            'nologin' => true
        ];

        return view('layout.index',['data' =>  $data]);
    }

    public function generateKcontact(Request $request)
    {
        $rules = [
            'nd_internet' => 'required',
            'lpc' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'addon' => 'required',
            'speed' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 400,
                'errors' => $isValid->errors()
            ]);
        }else{
            $nd = substr($request->input('nd_internet'),1,9);
            $tgl = date('Ymd'); 
            $pattern = 'LPIH-'.$tgl.''.$nd.';LANDINGPAGE_CRL_LPC'.$request->input("lpc").';'.$request->input("addon").' '.$request->input("speed").' Mbps;'.$request->input("nama").';'.$request->input("no_hp").';LPIH';

            return response([
                'status' => 200,
                'result' => $pattern
            ]);
        }
    }
}
