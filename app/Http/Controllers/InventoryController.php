<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class InventoryController extends Controller
{
    public function item()
    {
        $data = [
            'title' => 'Item',
            'content' => 'admin.inv_item',
            'masterItem' => DB::table('inv_master')->where('tipe','item')->get(),
            'masterVendor' => DB::table('inv_master')->where('tipe','vendor')->get()
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select * from inv_item where deleted = 0');

        foreach ($query as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->item,
                $v->vendor,
                date('d/m/Y',strtotime($v->tanggal_masuk)),
                $v->stok,
                '
                <a href="javascript:void(0)" onclick="deleteItem('.$v->id.')" class="btn btn-block btn-danger text-white"><i class="fas fa-trash"></i> Hapus</a>
                 '
            ];
        }

        return response($response);
    }

    public function insertItem(Request $request)
    {
        $rules = [
            'item' => 'required',
            'stok' => 'required',
            'vendor' => 'required',
            'tanggal_masuk' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
           $response = [
               'status' => 401,
               'errors' => $isValid->errors()
           ];
           return response($response);
        }else{
            $data = [
                'item' => $request->input('item'),
                'stok' => $request->input('stok'),
                'vendor' => $request->input('vendor'),
                'tanggal_masuk' => $request->input('tanggal_masuk')
            ];

            $insert = DB::table('inv_item')->insert($data);
            if($insert){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan item!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan item!'
                ]);
            }
        }
    }

    public function editItem($id)
    {
        $query = DB::select('select * from inv_item where id = '.$id);
        return response($query);
    }

    public function updateItem(Request $request, $id)
    {
        $rules = [
            'item' => 'required',
            'stok' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
           $response = [
               'status' => 401,
               'errors' => $isValid->errors()
           ];
           return response($response);
        }else{
            $data = [
                'item' => $request->input('item'),
                'stok' => $request->input('stok')
            ];

            $update = DB::table('inv_item')->where('id',$id)->update($data);
            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil merubah item!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal merubah item!'
                ]);
            }
        }
    }

    public function deleteItem($id)
    {
        $query = DB::table('inv_item')->where('id',$id)->update([
            'deleted' => 1
        ]);
        if($query){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus item'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus item'
            ]);
        }

    }

    public function loadDataTransaksi(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select * from inv_transaksi');
        foreach ($query as $t => $g) {
            $button = '
            <a href="'.url('inv/transaksi/detail/'.$g->id).'" class="btn btn-primary btn-block"><i class="fas fa-file"></i> Detail</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-block text-white" onclick="deleteTransaksi('.$g->id.')"><i class="fas fa-trash"></i> Hapus</a>
            ';
            if($g->status == 'MENUNGGU PERSETUJUAN'){
                $status = '<div class="badge badge-danger">MENUNGGU PERSETUJUAN</div>';
                $button .= '<a href="javascript:void(0)" class="btn btn-success btn-block text-white" onclick="updateStatus('.$g->id.')"><i class="fas fa-check"></i> APPROVE</a>';
            }else if($g->status == 'BATAL'){
                $status = '<div class="badge badge-warning">BATAL</div>';
                $button = $button;
            }else{
                $status = '<div class="badge badge-success">DISETUJUI</div>';
                $button = $button;
            }

            $response['data'][] = [
                ++$t,
                $g->nomor_transaksi,
                $g->tanggal_transaksi,
                $g->keterangan,
                $status,
                $button
            ];
        }

        return response($response);
    }

    public function transaksi()
    {
        $data = [
            'title' => 'Transaksi',
            'content' => 'admin.inv_transaksi'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function generateNumber()
    {
        // $latestNumber = DB::select('select * from inv_transaksi order by created desc limit 1');
        // $newNumber = $latestNumber > 0 ? ($latestNumber + 1) : 1;
        // return $newNumber;
    }

    public function insertTransaksi()
    {
        $data = [
            'nomor_transaksi' => 'TSC-'.date('ymdhis'),
            'tanggal_transaksi' => date('Y-m-d H:i:s')
        ];

        $insert = DB::table('inv_transaksi')->insertGetId($data);
        if($insert){
            return redirect('inv/transaksi/detail/'.$insert)->with('success','Berhasil membuat transaksi baru.');
        }else{
            return redirect('inv/transaksi')->with('error','Gagal menambah transaksi baru!');
        }
    }

    public function deleteTransaksi($id)
    {
        $query = DB::select('delete from inv_transaksi where id = '.$id);
        if($query)
            $detail = DB::select('delete from inv_transaksi_detail where id_transaksi = '.$id);
                return response([
                    'status' =>  200,
                    'result' => 'Berhasil menghapus transaksi.'
                ]);

        return response([
            'status' =>  500,
            'result' => 'Gagal menghapus transaksi.'
        ]);
    }

    public function updateStatus($id)
    {
        $query = DB::select("update inv_transaksi set status = 'DISETUJUI' where id = $id");
        if($query)
            $getStok = DB::select('select * from inv_transaksi_detail where id_transaksi = '.$id);
            foreach ($getStok as $gs) {
                $getItemMaster = DB::table('inv_item')->where('id',$gs->id_item);
                $update = $getItemMaster->first()->stok - $gs->quantity;
                $getItemMaster->update(['stok' => $update]);
            }
            return response([
                'status' => 200,
                'result' => 'Berhasil mengubah status'
            ]);

        return response([
            'status' => 500,
            'result' => 'Gagal mengubah status.'
        ]);
    }

    public function detailTransaksi()
    {
        $data = [
            'title' => 'Detail Transaksi',
            'content' => 'admin.inv_transaksi_detail',
            'plasa' => DB::select('select * from plasas'),
            'item' => DB::select('select * from inv_item where deleted = 0'),
            'witel' => DB::select('select area witel from areas order by area')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadDataDetailTransaksi()
    {
        $response['data'] = [];
        $query = DB::select('select a.*, item from inv_transaksi_detail a left join inv_item b on a.id_item = b.id');

        foreach ($query as $d => $td) {
            $button = '
                <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteDetail('.$td->id.')"><i class="fas fa-trash"></i></a>
                ';

            $response['data'][] = [
                ++$d,
                $td->witel,
                $td->plasa,
                date('d/m/Y',strtotime($td->tgl_kirim)),
                $td->item,
                $td->quantity,
                $td->keterangan,
                $button
            ];
        }

        return response($response);
    }

    public function insertDetail(Request $request)
    {
        $rules = [
            'witel' => 'required',
            'quantity' => 'required',
            'tgl_kirim' => 'required',
            'item' => 'required',
            'tipe' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);
        if($isValid->fails()){
            $response = [
                'status' => 401,
                'errors' => $isValid->errors()
            ];
            return response($response);
        }else{
            $data = [
                'plasa' => $request->input('plasa'),
                'id_item' => $request->input('item'),
                'quantity' =>  $request->input('quantity'),
                'tgl_kirim' => $request->input('tgl_kirim'),
                'witel' => $request->input('witel'),
                'keterangan' =>  $request->input('keterangan'),
                'tipe' => $request->input('tipe')
            ];

            $insert = DB::table('inv_transaksi_detail')->insertGetId($data);
            if($insert)
                $this->calculateStok($request->input('item'),$request->input('quantity'),$insert);
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan kiriman baru.'
                ]);

            return response([
                'status' => 500,
                'result' => 'Gagal menambahkan kiriman baru'
            ]);
        }
    }

    public function deleteDetail($id)
    {
        $query = DB::select("delete from inv_transaksi_detail where id = $id");
        if($query)
            $query = DB::select("delete from inv_history where id_transaksi_detail = $id");
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus detail'
            ]);

        return response([
            'status' => 500,
            'result' => 'Gagal menghapus detail'
        ]);
    }

    public function calculateStok($id_item, $quantity,$id_transaksi_detail)
    {
        $item = DB::table('inv_item')->where('id',$id_item)->first();
        $totalQty = DB::table('inv_transaksi_detail')->where('id_item',$id_item)->sum('quantity');
        $stok_akhir = $item->stok - $totalQty;
        DB::table('inv_history')->insert([
            'id_item' => $id_item,
            'id_transaksi_detail' => $id_transaksi_detail,
            'stok_akhir' => $stok_akhir
        ]);
    }

    public function getStokAkhir()
    {
        $query = DB::select('select * from inv_transaksi_detail order by created asc');
        foreach ($query as $i => $v) {
            $this->calculateStok($v->id_item,$v->quantity);
        }
    }

    public function reportItem()
    {
        $data = [
            'title' => 'Report Item',
            'content' => 'admin.inv_report_item'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadDataReport(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select a.*, b.* from (
            select * from inv_item where deleted = 0
            ) a left join (
            select item, sum(quantity) all_stok from inv_transaksi_detail a left join inv_item b on a.id_item = b.id
            group by item
            ) b on a.item = b.item');

        foreach ($query as $i => $v) {
            // $stok_akhir =
           $stok_akhir = $v->stok - $v->all_stok;
            $response['data'][] = [
                ++$i,
                $v->item,
                $v->stok,
                $stok_akhir,
                '
                <a href="'.url('inv/report/detail/'.$v->item).'" class="btn btn-block btn-danger text-white"><i class="fas fa-table"></i> Detail</a>
                 '
            ];
        }

        return response($response);
    }

    public function reportItemDetail($id)
    {
        $q = DB::table('inv_item')->select('item')->where('item',$id)->groupBy('item')->get();
        $data = [
            'title' => 'Report Item Detail',
            'content' => 'admin.inv_report_detail',
            'ts' => $q[0]
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadDataReportDetail(Request $request, $id)
    {
        $response['data'] = [];
        $query = DB::select("select a.* from inv_transaksi_detail a left join inv_item b on a.id_item = b.id where b.item ='$id'");
        $qStok = DB::select("select stok from inv_item where item = '$id' and deleted = 0");
        $stok = $qStok[0]->stok;
        foreach ($query as $i => $v) {
            $plasa = $v->plasa == null ? '-' : $v->plasa;
            $witel = $v->witel == null ? '-' : $v->witel;
            $stok = $stok - $v->quantity;
            $response['data'][] = [
               $v->id,
               date('d-m-Y', strtotime($v->tgl_kirim)),
               $witel,
               $plasa,
               $v->keterangan,
               $v->quantity,
               $stok
            ];
        }

        return response($response);
    }

    public function stokPlasaPage()
    {
        $data = [
            'title' => 'Report Item Stok Plasa',
            'content' => 'admin.inv_stok_plasa',
        ];

        return view('layout.index',['data' => $data]);
    }

    public function stokPlasa()
    {
        $response['data'] = [];
        $query = DB::select("select a.*, coalesce(stok_redeem,0) stok_redeem, all_stok - coalesce(stok_redeem,0) sisa_stok from(
            select a.plasa, sum(quantity) all_stok
            from(
                    select plasa, quantity from inv_transaksi_detail where keterangan like '%redeem%'
            ) a
            group by a.plasa
            order by a.plasa
        ) a
        left join (
            select plasa,sum(case when periode is not null then 1 else 0 end) stok_redeem from inv_list_corporate group by plasa)
        b on a.plasa = b.plasa");

        foreach ($query as $i => $v) {
            $response['data'][] = [
                $v->plasa,
                $v->all_stok,
                $v->stok_redeem,
                $v->sisa_stok,
                '
                <a href="'.url('inv/report/plasa/detail/'.$v->plasa).'" class="btn btn-block btn-danger text-white"><i class="fas fa-table"></i> Detail</a>
                 '
            ];
        }
        return response($response);
    }

    public function stokPlasaPageDetail($plasa)
    {
        $data = [
            'title' => 'Report Item Stok Plasa Detail',
            'content' => 'admin.inv_stok_plasa_detail',
            'plasa' => $plasa
        ];

        return view('layout.index',['data' => $data]);
    }

    public function stokPlasaDetailLoad($plasa)
    {
        $response['data'] = [];
        $query = DB::select("select * from inv_transaksi_detail a left join inv_item b on a.id_item = b.id where a.plasa = '$plasa' and keterangan like '%redeem%'");

        foreach ($query as $i => $v) {
            $plasa = $v->plasa == null ? '-' : $v->plasa;
            $response['data'][] = [
               $v->id,
               $v->item,
               date('d-m-Y', strtotime($v->tgl_kirim)),
               $v->keterangan,
               $v->quantity
            ];
        }

        return response($response);
    }

    public function reportHvcPage()
    {
        $data = [
            'title' => 'Report Item HVC Witel',
            'content' => 'admin.inv_stok_hvc_witel',
        ];

        return view('layout.index',['data' => $data]);
    }

    public function reportHvc(Request $request)
    {
        $response['data'] = [];
        $query = DB::select("select witel, sum(quantity) all_stok from inv_transaksi_detail a left join inv_item b on a.id_item = b.id where keterangan like '%HVC%' or tipe = 2 group by witel");
        $no = 1;
        foreach ($query as $v) {
            $response['data'][] = [
                $no++,
                $v->witel,
                $v->all_stok,
                '<a href="'.url('inv/report/hvc/detail/'.$v->witel).'" class="btn btn-danger btn-block"><i class="fas fa-table"></i> Detail</a>'
            ];
        }

        return response($response);
    }

    public function reportHvcDetailPage($witel)
    {
        $data = [
            'title' => 'Report Detail HVC Item Witel',
            'content' => 'admin.inv_stok_hvc_detail_witel'
        ];
        return view('layout.index',['data' => $data]);
    }

    public function reportHvcDetail($id)
    {
        $response['data'] = [];
        $query = DB::select("select tgl_kirim, witel, keterangan, quantity from inv_transaksi_detail a left join inv_item b on a.id_item = b.id where witel = '$id' and keterangan like '%HVC%' or tipe = 2");
        $no = 1;
        foreach ($query as $v) {
            $response['data'][] = [
                $no++,
                date('d/m/Y H:i',strtotime($v->tgl_kirim)),
                $v->witel,
                $v->keterangan,
                $v->quantity
            ];
        }
        return response($response);
    }
}
