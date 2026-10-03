<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporBanjirController extends Controller
{
    
    public function create()
    {
        return view('laporbanjir.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'nama'      => ['required', 'string', 'min:3', 'max:100'],
                'kecamatan' => ['required', 'string', 'max:80'],
                'desa'      => ['required', 'string', 'max:80'],
                'tinggi'    => ['required', 'integer', 'min:1', 'max:500'],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'min'      => ':attribute minimal :min.',
                'max'      => ':attribute maksimal :max.',
                'integer'  => ':attribute harus berupa angka bulat.',
            ],
            [
                'nama'      => 'Nama pelapor',
                'kecamatan' => 'Kecamatan',
                'desa'      => 'Desa/kelurahan',
                'tinggi'    => 'Tinggi genangan',
            ]
        );

        $laporan = [
            'nama'      => strip_tags($data['nama']),
            'kecamatan' => strip_tags($data['kecamatan']),
            'desa'      => strip_tags($data['desa']),
            'tinggi'    => (int) $data['tinggi'],
            'kategori'  => $this->kategori((int) $data['tinggi']),
            'waktu'     => now('Asia/Jakarta')->translatedFormat('l, d F Y, H:i') . ' WIB',
        ];

        return view('laporbanjir.konfirmasi', compact('laporan'));
    }

    
    private function kategori(int $cm): array
    {
        return match (true) {
            $cm >= 120 => ['label' => 'Sangat tinggi', 'kelas' => 'sangat'],
            $cm >= 70  => ['label' => 'Tinggi',        'kelas' => 'tinggi'],
            $cm >= 30  => ['label' => 'Sedang',        'kelas' => 'sedang'],
            default    => ['label' => 'Rendah',        'kelas' => 'rendah'],
        };
    }
}
