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
        $witel_log = session('witel');
        if($witel_log != 'REGIONAL 5'){
            $wt = " area = '$witel_log'";
        }else{
            $witel = $request->input('witel');
            if($witel){
                $wt = "a.cwitel = $witel";
            }else{
                $wt = "1=1";
            }
        }

        $response['data'] = [];
        $query =  DB::select("select a.*,b.area from redeem_new a left join areas b on a.cwitel = b.cwitel where $wt");
        foreach ($query as $i => $v) {
            if($v->attachment == '' || $v->attachment == null){
                $status = '<b><i>Bukti pengiriman belum diupload</i></b>';
            }else{
                $status = '<i>Bukti pengiriman sudah diupload</i>';
            }

            if($v->plasa == '' || $v->plasa == null){
                $jenis = '<i> -- </i>';
            }else{
                $jenis = '<b><i>REDEEM PLASA</i></b>';
            }

            if($v->jenis_produk == '' || $v->jenis_produk == null){
                $produk = '<b><i> -- </i></b>';
            }else{
                $produk = '<b><i>'.$v->jenis_produk.'</i></b>';
            }
            
            $button = '<a href="'.url('admin/redeem/edit/'.$v->id).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Upload bukti pengiriman</a>';
            if(!$v->attachment == '')
                $button = '<a href="'.asset('backend/img/'.$v->attachment).'" target="_blank" class="btn btn-success btn-block"><i class="fas fa-eye"></i> Cek resi</a>';
            $response['data'][] = [
                ++$i,
                $v->nama_pelanggan,
                $v->nomor_hp,
                $v->nd_internet,
                $v->email_pelanggan,
                $v->alamat_pengiriman,
                $v->kode_voucher,
                $v->plasa,
                $v->area,
                $status,
                $jenis,
                $produk,
                date('d/m/Y H:i',strtotime($v->created)),
                $button
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
                    return redirect()->back()->with('success','Berhasil mengupload bukti pengiriman');
                }else{
                    return redirect()->back()->with('error','Terjadi kesalahan saat menyimpan!');
                }
            }else{
                return redirect()->back()->with('error','Terjadi kesalahan saat mengupload, sila coba lagi!');
            }
        }
    }

    public function report()
    {
        $data = [
            'title' => 'Report Redeem Point Progress',
            'content' => 'admin.redeem_report_admin'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function report_load(Request $request)
    {
        $response['data'] = [];
        if($request->get('jenis_report') == 'redeem-plasa'){
            $query = DB::select("SELECT *, PB+MOUSE+EARBUDS TOTAL
            FROM(
            SELECT AREA WITEL,
            SUM(CASE WHEN JENIS_PRODUK = 'POWER BANK' THEN 1 ELSE 0 END) PB,
            SUM(CASE WHEN JENIS_PRODUK = 'MOUSE' THEN 1 ELSE 0 END) MOUSE,
            SUM(CASE WHEN JENIS_PRODUK = 'EARBUDS' THEN 1 ELSE 0 END) EARBUDS
            FROM(
            SELECT * FROM REDEEM_NEW A LEFT JOIN AREAS B ON A.CWITEL = B.CWITEL 
            WHERE IS_PLASA IS NOT NULL
            ) A 
            GROUP BY AREA
            ) B
            ORDER BY TOTAL DESC");
            foreach ($query as $i => $v) {
                $response['data'][] = [
                    $v->witel,
                    $v->pb,
                    $v->mouse,
                    $v->earbuds,
                    $v->total
                ];
            }
        }else{
            $query = DB::select('select b.cwitel, b.area witel, count(*) jumlah from redeem_new a left join areas b on a.cwitel = b.cwitel group by b.area, b.cwitel');
            foreach ($query as $i => $v) {
                $response['data'][] = [
                    $v->witel,
                    '<a href="'.url('admin/redeem?witel='.$v->cwitel).'" target="_blank">'.$v->jumlah.'</a>'
                ];
            }
        }
        

        return response($response);
    }

    public function report_total(Request $request)
    {
        if($request->get('jenis_report') == 'redeem'){
            $query = DB::select("SELECT SUM(PB) TOT_PB,SUM(MOUSE) TOT_MOUSE, SUM(EARBUDS) TOT_EAR
            FROM(
            SELECT *, PB+MOUSE+EARBUDS TOTAL
            FROM(
            SELECT AREA,
            SUM(CASE WHEN JENIS_PRODUK = 'POWER BANK' THEN 1 ELSE 0 END) PB,
            SUM(CASE WHEN JENIS_PRODUK = 'MOUSE' THEN 1 ELSE 0 END) MOUSE,
            SUM(CASE WHEN JENIS_PRODUK = 'EARBUDS' THEN 1 ELSE 0 END) EARBUDS
            FROM(
            SELECT * FROM REDEEM_NEW A LEFT JOIN AREAS B ON A.CWITEL = B.CWITEL 
            WHERE IS_PLASA IS NOT NULL
            ) A 
            GROUP BY AREA
            ) B
            ORDER BY TOTAL DESC
            ) C");

            return response([
                'jenis' => 'redeem-plasa',
                'data' => $query
            ]);
        }else{
            $query = DB::select('
            select sum(jumlah) total from(
            select b.cwitel, b.area witel, count(*) jumlah from redeem_new a left join areas b on a.cwitel = b.cwitel group by b.area, b.cwitel
            ) a');

            return response([
                'jenis' => 'redeem',
                'data' => $query
            ]);
        }
    }

    public function report_detail($witel)
    {
        $response['data'] = [];
        $query = DB::select("select a.*,b.area from redeem_new a left join areas b on a.cwitel = b.cwitel where b.area = '$witel'");
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
                $v->kode_voucher,
                $v->area,
                $status,
                date('d/m/Y H:i',strtotime($v->created)),
                '<a href="'.url('admin/redeem/edit/'.$v->id).'" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Upload bukti pengiriman</a>'
            ];
        }

        return response($response);
    }

    //Redeem Plasa

    public function index_redeem_plasa()
    {
        $data = [
            'title' => 'Redeem Point Plasa',
            'pekerjaan' => DB::select('select * from redeem_pekerjaan'),
            'plasa' => DB::select("select b.area, a.plasa from areas b left join plasas a on b.cwitel = a.cwitel where area not in ('TAM MALANG','REGIONAL 5')")
        ];

        return view('redeem_plasa',$data);
    }

    public function register_plasa(Request $request)
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
            'kode_voucher' => 'required',
            'plasa' => 'required',
            'jenis_produk' => 'required'
            // 'disclaimer' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $kode_voucher = $request->input('kode_voucher');
            $q_check = DB::select("select * from redeem_new where kode_voucher = '$kode_voucher'");
            if(count($q_check)<=0){
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
                    'kode_voucher' => $request->input('kode_voucher'),
                    'plasa' => $request->input('plasa'),
                    'is_plasa' => $request->input('is_plasa'),
                    'jenis_produk' => $request->input('jenis_produk')
                ];
    
                $insert = DB::table('redeem_new')->insertGetId($data);
    
                if($insert){
                    return redirect()->back()->with('success','Redeem point berhasil!');
                }else{
                    return redirect()->back()->with('error','Terjadi kesalahan, redeem point gagal!');
                }
            }else{
                return redirect()->back()->with('error','Kode voucher sudah terdaftar!');
            }
        }
    }

    public function getWitel(Request $request)
    {
        $plasa = $request->input('plasa');

        $query = DB::select("select cwitel from plasas where plasa = '$plasa'");
        if($query){
            $data = [
                'status' => 200,
                'result' => $query[0],
                'message' => 'Witel ditemukan'
            ];

            return response($data);
        }else{
            $data = [
                'status' => 400,
                'result' => [],
                'message' => 'Witel tidak ditemukan'
            ];

            return response($data);
        }
    }
}
