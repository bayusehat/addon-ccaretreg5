<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Str;

class CombatChurnController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Combat Churn List',
            'content' => 'admin.cc_list',
            'menuOn' => 'list',
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select a.*,b.speed, c.kelompok kel from cc_form a join cc_master b on a.nd_internet = b.nd_internet join cc_kelompok c on a.kelompok = b.id');
        foreach ($query as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->nd_internet,
                $v->nama,
                $v->no_hp,
                $v->alamat,
                date('d/m/Y H:i',strtotime($v->created_at)),
                $v->kel,
                '
                <a href="'.url('cc/edit/'.$v->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                <a href="'.url('cc/delete/'.$v->id).'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                '
            ];
        }

        return response($response);
    }

    public function getDataPelanggan(Request $request)
    {
        $nd_internet = $request->get('nd');
        $query = DB::select("select b.area, a.* from cc_master a join areas b on a.cwitel = b.cwitel where nd_internet = '$nd_internet'");
        if($query){
            $data = [
                'status' => 200,
                'data' => $query
            ];
        }else{
            $data = [
                'status' => 500,
                'data' => []
            ];
        }
        return response($data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Combat Churn Form',
            'kelompok' => DB::select('select * from cc_kelompok'),
            'menuOn' => 'list',
            'content' => 'admin.cc_form',
            'pernyataan' => DB::select('select * from cc_pernyataan'),
            'provider' => DB::select('select * from cc_provider order by id'),
            'jenis_paket' => DB::select('select * from cc_jenis_paket')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'kelompok' => 'required',
            'nd_internet' => 'required',
            'voc1' => 'required',
            'voc2' => 'required',	
            'voc3' => 'required',	
            'voc4' => 'required',	
            'voc5' => 'required',	
            'voc6' => 'required',	
            'voc7' => 'required',	
            'voc8' => 'required',
            'attachment' => 'required'	
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'kelompok' => $request->input('kelompok'),
                'nd_internet' => $request->input('nd_internet'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'no_hp' => $request->input('no_hp')
            ];

            $insertParent = DB::table('cc_form')->insertGetId($data);
            if($insertParent){
                //VOCArr
                $arr = [1,3,4,5,6];
                foreach ($arr as $f) {
                    if($f<>7){
                        foreach ($request->input('voc'.$f) as $s => $k) {
                            $dataVocarr= [
                                'jawaban' => $k,
                                'id_form' => $insertParent,
                                'voc' => $f
                            ];
                            DB::table('cc_jawaban')->insert($dataVocarr);
                        }
                    }
                    if($request->input('voc'.$f.'_lain') != null){
                        $dataJawabLain = [
                            'jawaban_lain' => $request->input('voc'.$f.'_value'),
                            'jawaban' =>  $request->input('voc'.$f.'_lain'),
                            'id_form' => $insertParent,
                            'voc' => $f
                        ];

                        DB::table('cc_jawaban')->insert($dataJawabLain);
                    }
                    
                }
                
                //VOCnotArr
                $narr = [2,7,8,9,10];
                foreach ($narr as $nr) {
                    if($request->input('voc'.$nr) != null){
                        $dataJawabNotarr = [
                            'jawaban' => $request->input('voc'.$nr),
                            'id_form' => $insertParent,
                            'voc' => $nr
                        ];

                        DB::table('cc_jawaban')->insert($dataJawabNotarr);
                    }
                }
                
                //Attachment
                $f = $request->file('attachment');
                $name = Str::random(10).$f->getClientOriginalName();
                $f->move(public_path('/backend/combat_churn/'),$name);
                
                DB::table('cc_form')->where('id',$insertParent)->update(['attachment' =>  $name]);

                //Pernyataan
                // foreach ($request->input('jwb') as $i => $j) {
                //     $dPertanyaan = [
                //         'id_pernyataan' => $i,
                //         'id_form' => $insertParent,
                //         'prioritas' => $j
                //     ];

                //     DB::table('cc_form_pernyataan')->insert($dPertanyaan);
                // }
                return redirect()->back()->with('success', 'Berhasil menambahkan form!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan form!');
            }
        }
    }

    public function chart()
    {
        $data = [
            'title' => 'Chart',
            'content' => 'admin.cc_chart',
            'menuOn' => 'chart',
            'alasan_cabut' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 1 group by jawaban'),
            'pengalaman_baik' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 3 group by jawaban'),
            'pengalaman_kurang_baik' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 4 group by jawaban'),
            'provider' => DB::select('select provider jawaban, count(*) jml from cc_jawaban a left join cc_provider b on a.jawaban::integer = b.id where voc = 5 group by provider'),
            'kebutuhan' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 6 group by jawaban'),
            'jumlah_pengguna' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 7 group by jawaban'),
            'winback' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 8 group by jawaban'),
            'paket_pilihan' => DB::select("select concat(nama_paket,' - ', speed, ' - ', harga_paket) paket_pilihan, count(*) jml from cc_jawaban a left join cc_jenis_paket b on a.jawaban::integer = b.id where voc = 9 group by b.id"),
        ];
        return view('layout.index',['data' => $data]);
    }

    public function game()
    {
        $data = [
            'title' => 'Report Game',
            'content' => 'admin.cc_game',
            'menuOn' => 'game'
        ];
        return view('layout.index',['data' => $data]);
    }

    public function loadDataGame(Request $request)
    {
        $response['data'] = [];
        $query = DB::select("select a.*, case when nominal_winback is not null then nominal_winback else 0 end nominal_winback from (
            select a.*, case when jml_winback is not null then jml_winback else 0 end jml_winback from(
                select a.kelompok, case when b.jml_kunjungan is not null then b.jml_kunjungan else 0 end jml_kunjungan from cc_kelompok a left join 
                    (select kelompok, sum(case when attachment is not null then 1 else 0 end) jml_kunjungan from cc_form group by kelompok) b
                on a.id = b.kelompok) a
                left join (
                    select c.kelompok, count(*) jml_winback from cc_jawaban a 
                        join cc_form b on a.id_form = b.id
                        left join cc_kelompok c on b.kelompok = c.id 
                    where voc = 8 and jawaban = 'YA' 
                    group by c.kelompok
            ) b on a.kelompok = b.kelompok
        ) a left join (
            select c.kelompok, sum(d.harga_paket) nominal_winback from cc_jawaban a 
                    join cc_form b on a.id_form = b.id
                    left join cc_kelompok c on b.kelompok = c.id
                    left join cc_jenis_paket d on a.jawaban::integer = d.id
                where voc = 9
            group by c.kelompok
        ) b on a.kelompok = b.kelompok");
        $no = 1;
        foreach ($query as $ig => $g) {
            $response['data'][] = [
                $no++,
                $g->kelompok,
                $g->jml_kunjungan,
                $g->jml_winback,
                'Rp '.number_format($g->nominal_winback)
            ];
        }

        return response($response);
    }
}
