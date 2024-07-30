<?php

namespace App\Http\Controllers;

use App\Models\Pembicara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembicaraController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan Data pembicara
        $pembicara = Pembicara::all();

        // dd($kelas);
        if ($request->ajax()) {
            return datatables()->of($pembicara)
            ->addColumn('aksi', function ($data) {
                $button = '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <a href="javascript:void(0)" id="edit-pembicara" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-pembicara"><i class="fa-solid fa-pen"></i></a>
                    <button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                    <a href="pembicara/detail/' . $data->id . '" name="detail" class="detail btn btn-secondary btn-sm"><i class="far fa-eye"></i></a>
                    </div>
                </div>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->toJson();
        }

        return view('pembicara.index', compact(
        [
            'pembicara',
        ]));
    }

    public function store(Request $request)
    {
        $messages  = [
            'required' => 'Kolom harus diisi.',
            'string'   => 'Kolom harus berupa teks.',
            'numeric'  => 'Kolom harus berupa angka.',
            'max'      => 'Kolom maksimal :max kata.',
            'mimes'    => 'Format file harus jpg/png.',
        ];
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'phone'        => 'required|numeric',
            'email'        => 'required',
            'company'      => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'errors'    => $validator->messages()
            ]);
        } else {

            $nama_lengkap = $request->nama_lengkap;
            $phone        = $request->phone;
            $email        = $request->email;
            $company      = $request->company;

            // Buat objek Pembicara dan simpan data jika memenuhi syarat
            $pembicara               = new Pembicara;
            $pembicara->nama_lengkap = $nama_lengkap;
            $pembicara->phone        = $phone;
            $pembicara->email        = $email;
            $pembicara->company      = $company;
            $pembicara->save();

            // Tambahkan aktivitas log
            // \ActivityLog::addToLog('Menambah data pembicara');

            // Kirim respons berhasil
            return response()->json([
                'status' => 200,
                'message' => 'Data pembicara berhasil ditambahkan. '
            ]);
        }
    }

    public function edit($id)
    {
        $pembicara = Pembicara::find($id);
        return response()->json($pembicara);
    }

    public function update($id, Request $request)
    {
        $messages  = [
            'required' => 'Kolom :attribute harus diisi.',
            'string'   => 'Kolom :attribute harus berupa huruf.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'alpha'    => 'Kolom :attribute harus berupa huruf.',
            'max'      => 'Kolom :attribute maksimal :max kata.',
        ];
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'phone'        => 'required|numeric',
            'email'        => 'required|email',
            'company'      => 'required|max:255'
        ],$messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            // dd($request->all());
            // \ActivityLog::addToLog('Mengedit data pembicara');

            $pembicara               = Pembicara::find($id);
            $pembicara->nama_lengkap = $request->nama_lengkap;
            $pembicara->phone        = $request->phone;
            $pembicara->email        = $request->email;
            $pembicara->company      = $request->company;
            $pembicara->save();

            return response()->json([
                'status'    => 200,
                'message'   => 'Sukses! Data pembicara berhasil diupdate'
            ]);
        }
    }

    public function destroy($id)
    {
        $pembicara = Pembicara::find($id);

        // \ActivityLog::addToLog('Menghapus data pembicara');

        if ($pembicara) {
            $pembicara->delete();
            return response()->json([
                'status'    => 200,
                'message'   => 'Sukses! Data pembicara berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status'    => 404,
                'errors'    => 'Error! Data pembicara tidak ditemukan'
            ]);
        }
    }
}
