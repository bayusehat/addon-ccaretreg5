<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class ValController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Validasi nomor dinas kantor TR5',
            'content' => 'admin.val_list'
        ];
        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select area witel, a.* from val_form a left join areas b on a.cwitel = b.cwitel where a.deleted_at is null');
        $no = 1;
        foreach ($query as $i => $v) {
            $response['data'][] = [
                $no++,
                $v->nd_internet,
                $v->nama,
                $v->alamat,
                date('d/m/Y H:i',strtotime($v->created_at)),
                '
                <a href="'.url('val/edit/'.$v->id).'" class="btn btn-block btn-primary text-white"><i class="fas fa-table"></i> Detail</a>
                <a href="javascript:void(0)" class="btn btn-block btn-danger text-white" onclick="deleteValidasi('.$v->id.')"><i class="fas fa-trash"></i> Delete</a>
                '
            ];
        }

        return response($response);
    }

    public function getData(Request $request)
    {
        $nd = $request->get('nd');
        $query = DB::select("
            select area witel, a.* from val_master a left join areas b on a.cwitel = b.cwitel where nd_internet = '$nd'
        ");
        if($query){
            return response([
                'status' => 200,
                'data' => $query[0]
            ]);
        }else{
            return response([
                'status' => 500,
                'data' => []
            ]);
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Insert new data validasi',
            'content' => 'admin.val_form',
            'area' => DB::select('select * from areas')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'nd_internet' => 'required',
            'nama' => 'required',
            'witel' => 'required',
            'unit' => 'required',
            'nik_pic_organik' => 'required',
            'jabatan_pic' => 'required',
            'no_hp_pic' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'nd_internet' => $request->input('nd_internet'),
                'nama' => $request->input('nama'),
                'cwitel' => $request->input('witel'),
                'nd_pots' => $request->input('nd_pots'),
                'sto' => $request->input('sto'),
                'alamat' => $request->input('alamat'),
                'unit' => $request->input('unit'),
                'nik_pic_organik' => $request->input('nik_pic_organik'),
                'jabatan_pic' => $request->input('jabatan_pic'),
                'no_hp_pic' => $request->input('no_hp_pic')
            ];

            $insert = DB::table('val_form')->insert($data);

            if($insert){
                return redirect()->back()->with('success','Berhasil menambahkan data validasi baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan data validasi baru!');
            }
        }
    }

    public function edit($id)
    {
        $query = DB::select('select area witel, a.* from val_form a left join areas b on a.cwitel = b.cwitel where a.id = '.$id);
        $data = [
            'title' => 'Edit Validasi nomor dinas kantor Form',
            'content' => 'admin.val_form_edit',
            'data' => $query[0]
        ];
        return view('layout.index',['data'=>$data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nd_internet' => 'required',
            'nama' => 'required',
            'witel' => 'required',
            'unit' => 'required',
            'nik_pic_organik' => 'required',
            'jabatan_pic' => 'required',
            'no_hp_pic' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'nd_internet' => $request->input('nd_internet'),
                'nama' => $request->input('nama'),
                'cwitel' => $request->input('witel'),
                'nd_pots' => $request->input('nd_pots'),
                'sto' => $request->input('sto'),
                'alamat' => $request->input('alamat'),
                'unit' => $request->input('unit'),
                'nik_pic_organik' => $request->input('nik_pic_organik'),
                'jabatan_pic' => $request->input('jabatan_pic'),
                'no_hp_pic' => $request->input('no_hp_pic'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $update = DB::table('val_form')->update($data);

            if($update){
                return redirect()->back()->with('success','Berhasil memperbarui data validasi!');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui data validasi!');
            }
        }
    }

    public function destroy($id)
    {
        $query = DB::table('val_form')->update([
            'deleted_at' => date('Y-m-d H:i:s')
        ]);
        if($query){
            return response([
                'status' => 200,
                'message' => 'Berhasil menghapus data Validasi'
            ]);
        }else{
            return response([
                'status' => 500,
                'message' => 'Gagal menghapus data Validasi'
            ]);
        }
    }
}
