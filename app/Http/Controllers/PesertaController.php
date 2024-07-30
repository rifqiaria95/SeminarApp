<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Peserta;
use App\Models\Konfirmasi;
use App\Models\DataSeminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $peserta = Peserta::all();
        $startDate = now()->subDays(30);
        $endDate = now();
        $seminar = DataSeminar::whereBetween('created_at', [$startDate, $endDate])->get();
        $userRole = Auth::user()->role;

        if ($request->ajax()) {
            return datatables()->of($peserta)
                ->addColumn('seminar', function (Peserta $peserta) {
                    return $peserta->data_seminar->judul ?? 'N/A';
                })
                ->addColumn('aksi', function ($data) {
                    $button = 
                    '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group me-2" role="group" aria-label="First group">
                            <a href="javascript:void(0)" id="edit-peserta" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-peserta"><i class="fa-solid fa-pen"></i></a>
                            <button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                            <a href="peserta/detail/' . $data->id . '" name="detail" class="detail btn btn-secondary btn-sm"><i class="far fa-eye"></i></a>
                        </div>
                    </div>';
                    return $button;
                })
                ->rawColumns(['aksi'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('peserta.index', compact('peserta', 'userRole', 'seminar'));
    }

    public function create()
    {
        $seminar = DataSeminar::all();
        return view('peserta.create', compact('seminar'));
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'string'   => 'Kolom :attribute harus berupa teks.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'max'      => 'Kolom :attribute maksimal :max karakter.',
            'email'    => 'Format email tidak valid.',
        ];

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'phone'        => 'required|numeric',
            'email'        => 'required|email',
            'company'      => 'required|string|max:255'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        try {
            DB::beginTransaction();

            // Generate kode_registrasi
            $kodeRegistrasi = Helper::IDGenerator(Peserta::class, 'kode_registrasi', 5, 'MSIUS');

            // Create peserta record with kode_registrasi
            $peserta = Peserta::create([
                'kode_registrasi' => $kodeRegistrasi,
                'nama_lengkap'    => $request->nama_lengkap,
                'phone'           => $request->phone,
                'email'           => $request->email,
                'company'         => $request->company,
                'data_seminar_id' => $request->data_seminar_id,
                // Tambahkan field lain yang dibutuhkan di sini
            ]);

            // Create konfirmasi record with peserta_id
            $konfirmasi = Konfirmasi::create([
                'bukti_pembayaran'  => '-',
                'status_pembayaran' => 0,
                'peserta_id'        => $peserta->id,
            ]);

            DB::commit();

            return response()->json([
                'status'  => 200,
                'message' => 'Data peserta berhasil ditambahkan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 500,
                'message' => 'Gagal menyimpan data. Silakan coba lagi.',
                'error'   => $e->getMessage(),
            ]);
        }
    }


    public function edit($id)
    {
        $peserta = Peserta::with('data_seminar')->find($id);
        return response()->json($peserta);
    }

    public function update($id, Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'string'   => 'Kolom :attribute harus berupa teks.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'email'    => 'Format email tidak valid.',
            'max'      => 'Kolom :attribute maksimal :max karakter.',
        ];
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'phone'        => 'required|numeric',
            'email'        => 'required|email',
            'company'      => 'required|string|max:255',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $peserta = Peserta::find($id);
        if ($peserta) {
            $peserta->update($request->all());

            return response()->json([
                'status'  => 200,
                'message' => 'Data peserta berhasil diupdate.',
            ]);
        }

        return response()->json([
            'status' => 404,
            'errors' => 'Data peserta tidak ditemukan.',
        ]);
    }

    public function destroy($id)
    {
        $peserta = Peserta::find($id);

        if ($peserta) {
            $peserta->delete();

            return response()->json([
                'status'  => 200,
                'message' => 'Data peserta berhasil dihapus.',
            ]);
        }

        return response()->json([
            'status'  => 404,
            'errors'  => 'Data peserta tidak ditemukan.',
        ]);
    }
}
