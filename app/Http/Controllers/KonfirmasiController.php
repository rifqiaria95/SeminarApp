<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Konfirmasi;
use App\Models\DataSeminar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KonfirmasiController extends Controller
{
    public function index(Request $request)
    {
        $konfirmasi = Konfirmasi::with('peserta.data_seminar')->get();

        if ($request->ajax()) {
            return datatables()->of($konfirmasi)
                ->addColumn('kode_registrasi', function(Konfirmasi $konfirmasi) {
                    return $konfirmasi->peserta->kode_registrasi;
                })
                ->addColumn('nama_lengkap', function(Konfirmasi $konfirmasi) {
                    return $konfirmasi->peserta->nama_lengkap;
                })
                ->addColumn('phone', function(Konfirmasi $konfirmasi) {
                    return $konfirmasi->peserta->phone;
                })
                ->addColumn('judul', function(Konfirmasi $konfirmasi) {
                    return $konfirmasi->peserta->data_seminar->judul;
                })
                ->addColumn('status_pembayaran', function(Konfirmasi $konfirmasi) {
                    $pending = '<span class="badge bg-label-warning">Pending</span>';
                    $Lunas   = '<span class="badge bg-label-success">Lunas</span>';

                    return $konfirmasi->status_pembayaran === 0 ? $pending : $lunas;
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group me-2" role="group" aria-label="First group">
                        <a href="javascript:void(0)" id="edit-konfirmasi" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edit-konfirmasi"><i class="fa-solid fa-pen"></i></a>
                        <a href="konfirmasi/upload/' . $data->id . '/' . $data->peserta->kode_registrasi . '" target="__blank" name="confirm" class="confirm btn btn-success btn-sm"><i class="far fa-circle-check"></i></a>
                        <a href="konfirmasi/detail/' . $data->peserta->id . '" name="detail" class="detail btn btn-secondary btn-sm"><i class="far fa-eye"></i></a>
                    </div>
                    </div>';
                    return $button;
                })
                ->rawColumns(['aksi', 'kode_registrasi', 'nama_lengkap', 'phone', 'judul', 'status_pembayaran'])
                ->addIndexColumn()
                ->toJson();
        }

        return view('konfirmasi.index', compact('konfirmasi'));
    }


    public function edit($id)
    {
        $konfirmasi = Konfirmasi::with('peserta')->find($id);
        return response()->json($konfirmasi);
    }

    public function update($id, Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'integer'  => 'Kolom :attribute harus berupa angka.',
        ];

        $validator = Validator::make($request->all(), [
            'status_pembayaran' => 'required|integer',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        try {
            $konfirmasi = Konfirmasi::find($id);

            if (!$konfirmasi) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Konfirmasi tidak ditemukan'
                ]);
            }

            $konfirmasi->status_pembayaran = $request->status_pembayaran;
            $konfirmasi->save();

            if ($request->status_pembayaran == 1) {
                $peserta = $konfirmasi->peserta;

                if (!$peserta) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Peserta tidak ditemukan'
                    ]);
                }

                $dataSeminar = $peserta->data_seminar;

                if (!$dataSeminar) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Data Seminar tidak ditemukan'
                    ]);
                }

                // Generate QR code data
                $qrData = [
                    'Kode Registrasi'   => $peserta->kode_registrasi,
                    'Nama Lengkap'      => $peserta->nama_lengkap,
                    'No. Tlp'           => $peserta->phone,
                    'Email'             => $peserta->email,
                    'Company'           => $peserta->company,
                    'Judul Seminar'     => $dataSeminar->judul,
                    'Status Pembayaran' => 'Lunas'
                ];

                // Generate QR code image and store it
                $qrCodeImage = 'qrcodes/' . Str::slug($peserta->nama_lengkap) . '.png'; // Ensure file name is valid
                QrCode::format('png')->size(300)->generate(json_encode($qrData), public_path($qrCodeImage));

                return response()->json([
                    'status' => 200,
                    'message' => 'Sukses! Pembayaran telah dikonfirmasi',
                    'qr_code' => $qrCodeImage // Return the path to the QR code image
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Sukses! Pembayaran telah dikonfirmasi'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal menyimpan data. Silakan coba lagi.',
                'error' => $e->getMessage() // Tambahkan ini untuk debugging
            ]);
        }
    }

    public function updateBuktiPembayaran($id, $kode_registrasi, Request $request)
    {
        $messages = [
            'required' => 'Kolom :attribute harus diisi.',
            'integer'  => 'Kolom :attribute harus berupa angka.',
            'max'      => 'File :attribute maksimal 2MB.',
        ];

        $validator = Validator::make($request->all(), [
            'status_pembayaran' => 'required|integer',
            'bukti_pembayaran'  => 'required|file|max:2048',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        try {
            $konfirmasi = Konfirmasi::find($id);

            if (!$konfirmasi) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Konfirmasi tidak ditemukan'
                ]);
            }

            // Cek apakah status_pembayaran sudah 1
            if ($konfirmasi->status_pembayaran === 1) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'Pembayaran kamu telah terkonfirmasi.'
                ]);
            }

            $konfirmasi->status_pembayaran = 0;

            // Jika bukti_pembayaran adalah file, maka simpan file tersebut
            if ($request->hasFile('bukti_pembayaran')) {
                $file      = $request->file('bukti_pembayaran');
                $extension = $file->getClientOriginalExtension();
                $filename  = $konfirmasi->peserta->kode_registrasi . '.' . $extension;
                $path      = $file->storeAs('bukti_pembayaran', $filename, 'public');
                $konfirmasi->bukti_pembayaran = $path;
            }

            $konfirmasi->save();

            return response()->json([
                'status'  => 200,
                'message' => 'Sukses! Bukti Pembayaran Berhasil Diupload'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => 'Gagal menyimpan data. Silakan coba lagi.',
                'error'   => $e->getMessage()
            ]);
        }
    }


    public function detailPembayaran($id)
    {
        // Mengambil peserta atau melemparkan error jika tidak ditemukan
        $peserta = Peserta::findOrFail($id);

        // Mengambil konfirmasi yang terkait dengan peserta (misalnya jika ada relasi)
        $konfirmasi = Konfirmasi::where('peserta_id', $id)->get();

        // Mengirim data ke tampilan
        return view('konfirmasi.detail', compact('peserta', 'konfirmasi'));
    }

    public function uploadBukti($id)
    {
        $peserta    = Peserta::findOrFail($id);
        $konfirmasi = Konfirmasi::where('peserta_id', $id)->first();

        return view('konfirmasi.upload', [
            'peserta'    => $peserta,
            'konfirmasi' => $konfirmasi
        ]);
    }




}
