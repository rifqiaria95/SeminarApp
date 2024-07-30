<?php

namespace App\Http\Controllers;

use App\Models\Pembicara;
use App\Models\DataSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeminarController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan Data perusahaan
        $seminar   = DataSeminar::all();
        $pembicara = Pembicara::all();

        // dd($kelas);
        if ($request->ajax()) {
            return datatables()->of($seminar)
            ->addColumn('aksi', function ($data) {
                $button = '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <a href="javascript:void(0)" id="edit-seminar" data-toggle="tooltip"  data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-seminar"><i class="fa-solid fa-pen"></i></a>
                    <button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                    <a href="seminar/detail/' . $data->id . '" name="detail" class="detail btn btn-secondary btn-sm"><i class="far fa-eye"></i></a>
                    </div>
                </div>';
                return $button;
            })
            ->rawColumns(['aksi', 'pembicara'])
            ->addIndexColumn()
            ->toJson();
        }

        return view('seminar.index', compact(
        [
            'seminar',
            'pembicara',
        ]));
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom harus diisi.',
            'string'   => 'Kolom harus berupa teks.',
            'numeric'  => 'Kolom harus berupa angka.',
            'max'      => 'Kolom maksimal :max kata.',
            'mimes'    => 'Format file harus jpg/png.',
        ];

        $validator = Validator::make($request->all(), [
            'judul'        => 'required|string|max:255',
            'link'         => 'required|url|max:255',
            'tanggal'      => 'required|date',
            'harga'        => 'required',
            'pembicara_id' => 'required',
            'lampiran'     => 'nullable|mimes:jpg,png|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $seminar          = new DataSeminar;
            $seminar->judul   = $request->judul;
            $seminar->link    = $request->link;
            $seminar->tanggal = $request->tanggal;
            $seminar->harga   = $request->harga;

            if ($request->hasFile('lampiran')) {
                $path = $request->file('lampiran')->store('public/lampiran');
                $seminar->lampiran = $path;
            }

            $seminar->save();

            // Menyimpan pembicara
            foreach ($request->pembicara_id as $pembicaraId) {
                $seminar->pembicara()->attach($pembicaraId);
            }

            // Tambahkan aktivitas log
            // \ActivityLog::addToLog('Menambah data seminar');

            return response()->json([
                'status'  => 200,
                'message' => 'Data seminar berhasil ditambahkan.'
            ]);
        }
    }

    public function edit($id)
    {
        $seminar = DataSeminar::with('pembicara')->find($id);

        if (!$seminar) {
            return response()->json([
                'status'  => 404,
                'message' => 'Data tidak ditemukan.'
            ]);
        }

        $pembicaras = Pembicara::all();

        return response()->json([
            'status'       => 200,
            'judul'        => $seminar->judul,
            'link'         => $seminar->link,
            'tanggal'      => $seminar->tanggal,
            'harga'        => $seminar->harga,
            'lampiran'     => $seminar->lampiran,
            'pembicara'    => $pembicaras, // Mengirim semua data pembicara
            'pembicara_id' => $seminar->pembicara->pluck('id')->toArray() // Mengambil hanya id dari pembicara
        ]);
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
            'judul'    => 'required',
            'link'     => 'required',
            'tanggal'  => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            // dd($request->all());
            // \ActivityLog::addToLog('Mengedit data perusahaan');

            $seminar           = DataSeminar::findOrFail($id);
            $seminar->judul    = $request->judul;
            $seminar->link     = $request->link;
            $seminar->tanggal  = $request->tanggal;
            $seminar->harga    = $request->harga;
            $seminar->lampiran = $request->lampiran;
            $seminar->save();

            // Mengelola hubungan pembicara
            $seminar->pembicara()->sync($request->pembicara_id);

            return response()->json([
                'status'  => 200,
                'message' => 'Data seminar berhasil diperbarui.'
            ]);
        }
    }

    public function destroy($id)
    {
        $seminar = DataSeminar::find($id);

        // \ActivityLog::addToLog('Menghapus data seminar');

        if ($seminar) {
            $seminar->delete();
            return response()->json([
                'status'    => 200,
                'message'   => 'Sukses! Data seminar berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status'    => 404,
                'errors'    => 'Error! Data seminar tidak ditemukan'
            ]);
        }
    }

    public function removePembicara(Request $request)
    {
        $seminar = DataSeminar::find($request->seminar_id);
        if (!$seminar) {
            return response()->json([
                'status'  => 404,
                'message' => 'Seminar not found.'
            ]);
        }

        // Hapus hubungan pembicara dengan seminar
        $seminar->pembicara()->detach($request->pembicara_id);

        return response()->json([
            'status'  => 200,
            'message' => 'Pembicara removed successfully.'
        ]);
    }

}
