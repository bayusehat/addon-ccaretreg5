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
        $query = DB::select('select a.*,b.speed, c.kelompok kel from cc_form a join cc_master b on a.nd_internet = b.nd_internet left join cc_kelompok c on a.kelompok = c.id where a.deleted_at is null');
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
                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteForm('.$v->id.')"><i class="fas fa-trash"></i></a>
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
            'jenis_paket' => DB::select('select * from cc_jenis_paket order by p, harga_paket')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'kelompok' => 'required',
            'nd_internet' => 'required',
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
                $arr = [1,3,4,5,6,11,12];
                foreach ($arr as $f) {
                    if($f<>7){
                        if($request->input('voc'.$f)){
                            foreach ($request->input('voc'.$f) as $s => $k) {
                                $dataVocarr= [
                                    'jawaban' => $k,
                                    'id_form' => $insertParent,
                                    'voc' => $f
                                ];
                                DB::table('cc_jawaban')->insert($dataVocarr);
                            }
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
            'alasan_cabut' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 1 and deleted_at is null group by jawaban'),
            'pengalaman_baik_ih' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 3 and deleted_at is null group by jawaban'),
            'pengalaman_kurang_baik_ih' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 4 and deleted_at is null group by jawaban'),
            'provider' => DB::select('select provider jawaban, count(*) jml from cc_jawaban a left join cc_provider b on a.jawaban::integer = b.id where voc = 5 and a.deleted_at is null group by provider'),
            'kebutuhan' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 6 and deleted_at is null group by jawaban'),
            'jumlah_pengguna' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 7 and deleted_at is null group by jawaban'),
            'winback' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 8 and deleted_at is null group by jawaban'),
            'paket_pilihan' => DB::select("select concat(nama_paket,' - ', speed, ' - ', harga_paket) paket_pilihan, count(*) jml from cc_jawaban a left join cc_jenis_paket b on a.jawaban::integer = b.id where voc = 9 and a.deleted_at is null group by b.id"),
            'posisi_nte' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 2 and deleted_at is null group by jawaban'),
            'pengalaman_baik_ps' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 11 and deleted_at is null group by jawaban'),
            'pengalaman_kurang_baik_ps' => DB::select('select jawaban, count(*) jml from cc_jawaban where voc = 12 and deleted_at is null group by jawaban'),
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
                    (select kelompok, sum(case when attachment is not null then 1 else 0 end) jml_kunjungan from cc_form where deleted_at is null group by kelompok) b
                on a.id = b.kelompok) a
                left join (
                    select c.kelompok, count(*) jml_winback from cc_jawaban a 
                        join cc_form b on a.id_form = b.id
                        left join cc_kelompok c on b.kelompok = c.id 
                    where voc = 8 and jawaban = 'YA' and a.deleted_at is null
                    group by c.kelompok
            ) b on a.kelompok = b.kelompok
        ) a left join (
            select c.kelompok, sum(d.harga_paket) nominal_winback from cc_jawaban a 
                    join cc_form b on a.id_form = b.id
                    left join cc_kelompok c on b.kelompok = c.id
                    left join cc_jenis_paket d on a.jawaban::integer = d.id
                where voc = 9 and a.deleted_at is null
            group by c.kelompok
        ) b on a.kelompok = b.kelompok");
        $no = 1;
        foreach ($query as $ig => $g) {
            $response['data'][] = [
                $no++,
                '<a href="'.url('cc/game/evidence/'.$g->kelompok).'">'.$g->kelompok.'</a>',
                $g->jml_kunjungan,
                $g->jml_winback,
                'Rp '.number_format($g->nominal_winback)
            ];
        }

        return response($response);
    }

    public function getEvidence($kelompok)
    {
        $kel = DB::select("select * from cc_kelompok where kelompok = '$kelompok'");
        $data = [
            'title' => 'Report Game',
            'content' => 'admin.cc_gallery_evidence',
            'menuOn' => 'game',
            'kel' => $kel[0],
            'evidence' => DB::select("select * from cc_form a left join cc_kelompok b on a.kelompok = b.id where b.kelompok = '$kelompok' and a.deleted_at is null")
        ];
        return view('layout.index',['data' => $data]);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Combat Churn Form',
            'kelompok' => DB::select('select * from cc_kelompok'),
            'form' => DB::select('select * from cc_from a left join cc_kelompok b on a.kelompok = b.id where id = '. $id),
            'menuOn' => 'list',
            'content' => 'admin.cc_form_edit',
            'pernyataan' => DB::select('select * from cc_pernyataan'),
            'provider' => DB::select('select * from cc_provider order by id'),
            'jenis_paket' => DB::select('select * from cc_jenis_paket order by p, harga_paket')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function destroy($id)
    {
        $queryParent = DB::table('cc_form')->where('id',$id)->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        if($queryParent){
            $queryDetail = DB::table('cc_jawaban')->where('id_form',$id)->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
            if($queryDetail){
                return response([
                    'status' => 200,
                    'message' => 'Berhasil menghapus data Form dengan detail'
                ]);
            }else{
                return response([
                    'status' => 200,
                    'message' => 'Gagal menghapus data Form dengan detail'
                ]);
            }
        }else{
            return response([
                'status' => 200,
                'message' => 'Gagal menghapus data Form tanpa detail'
            ]);
        }
    }

    public function insertReport()
    {
        $query = DB::select('select id_form from cc_jawaban where deleted_at is null');
        foreach ($query as $i => $v) {
            $inserToReport = DB::table('cc_report_rows')->insert([
                'id_form' => $v->id_form
            ]);
            $queryDetail = DB::select('select * from cc_jawaban where deleted_at is null');
            // foreach ($queryDetail as $q => $d) {
            //     if($d->voc == 1){
            //         $dataUpdate
            //     }
            //     if($d->voc == 12){
                    
            //     }
            //     if($d->voc == 2){
                    
            //     }
            //     if($d->voc == 3){
                    
            //     }
            //     if($d->voc == 4){
                    
            //     }
            //     if($d->voc == 5){
                    
            //     }
            //     if($d->voc == 6){
                    
            //     }
            //     if($d->voc == 7){
                    
            //     }
            //     if($d->voc == 8){
                    
            //     }
            //     if($d->voc == 9){
                    
            //     }
            //     if($d->voc == 10){
                    
            //     }
            //     if($d->voc == 11){
                    
            //     }
            // }
        }

        
        
    }
}
