@extends('layouts.laporbanjir')

@section('title', 'Laporan Diterima')

@section('content')
    <h1 class="success-title"><span class="dot" aria-hidden="true"></span>Laporan Anda sudah diterima</h1>
    <p class="lead">Berikut data yang Anda kirim. Periksa kembali, lalu buat laporan baru jika ada yang perlu diperbaiki.</p>

    <div class="layout">
        <div class="card">
            <dl class="data">
                <dt>Nama pelapor</dt>
                <dd>{{ $laporan['nama'] }}</dd>

                <dt>Lokasi kejadian</dt>
                <dd>Desa/kelurahan {{ $laporan['desa'] }}, Kecamatan {{ $laporan['kecamatan'] }}</dd>

                <dt>Tinggi genangan</dt>
                <dd>
                    {{ $laporan['tinggi'] }} cm
                    <span class="badge {{ $laporan['kategori']['kelas'] }}">{{ $laporan['kategori']['label'] }}</span>
                </dd>

                <dt>Waktu laporan</dt>
                <dd>{{ $laporan['waktu'] }}</dd>
            </dl>

            <p class="notice">Ini prototipe: data hanya ditampilkan di halaman ini dan tidak disimpan.</p>

            <div class="actions">
                <a class="btn" href="{{ route('laporbanjir.form') }}">Buat laporan baru</a>
                <button type="button" class="btn ghost" id="btn-cetak">Cetak halaman</button>
            </div>
        </div>

        <aside aria-label="Gambaran tinggi genangan">
            <div class="gauge" style="--level: {{ min($laporan['tinggi'], 150) / 150 * 100 }}%">
                <div class="tube"><div class="fill"></div></div>
                <div class="mark" style="--at: 13.3%">Mata kaki</div>
                <div class="mark" style="--at: 33.3%">Lutut</div>
                <div class="mark" style="--at: 66.7%">Pinggang</div>
                <div class="mark" style="--at: 86.7%">Dada</div>
            </div>
            <p class="gauge-cap">Genangan <strong>{{ $laporan['tinggi'] }} cm</strong></p>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('btn-cetak').addEventListener('click', function () {
            window.print();
        });
    </script>
@endpush
