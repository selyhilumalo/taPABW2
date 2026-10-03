@extends('layouts.laporbanjir')

@section('title', 'Form Pelaporan Banjir')

@section('content')
    <h1>Laporkan banjir di wilayah Anda</h1>
    <p class="lead">Isi data berikut agar petugas BPBD dapat mengetahui lokasi dan tinggi genangan air.</p>

    <div class="layout">
        <form class="card" id="form-lapor" method="POST" action="{{ route('laporbanjir.kirim') }}" novalidate>
            @csrf

            @if ($errors->any())
                <div class="alert" role="alert">Laporan belum terkirim. Periksa isian yang ditandai di bawah.</div>
            @endif

            <div class="field">
                <label for="nama">Nama pelapor</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" autocomplete="name"
                       class="{{ $errors->has('nama') ? 'invalid' : '' }}" required>
                @error('nama') <p class="err">{{ $message }}</p> @enderror
            </div>

            <div class="row">
                <div class="field">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" list="daftar-kecamatan"
                           class="{{ $errors->has('kecamatan') ? 'invalid' : '' }}" required>
                    <datalist id="daftar-kecamatan">
                        @foreach (['Baleendah', 'Banjaran', 'Bojongsoang', 'Cileunyi', 'Dayeuhkolot', 'Katapang', 'Majalaya', 'Pameungpeuk', 'Rancaekek', 'Soreang'] as $k)
                            <option value="{{ $k }}">
                        @endforeach
                    </datalist>
                    @error('kecamatan') <p class="err">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="desa">Desa/kelurahan</label>
                    <input type="text" id="desa" name="desa" value="{{ old('desa') }}"
                           class="{{ $errors->has('desa') ? 'invalid' : '' }}" required>
                    @error('desa') <p class="err">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="field">
                <label for="tinggi">Tinggi genangan air
                    <span class="hint">Perkirakan dari ketinggian air di tempat Anda. Lihat acuan di samping.</span>
                </label>
                <div class="input-unit">
                    <input type="number" id="tinggi" name="tinggi" value="{{ old('tinggi') }}" min="1" max="500" step="1" inputmode="numeric"
                           class="{{ $errors->has('tinggi') ? 'invalid' : '' }}" required>
                    <span>cm</span>
                </div>
                @error('tinggi') <p class="err">{{ $message }}</p> @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn" id="btn-kirim">Kirim laporan</button>
            </div>
        </form>

        <aside aria-label="Acuan tinggi genangan">
            <div class="gauge" id="gauge" style="--level: 0%">
                <div class="tube"><div class="fill"></div></div>
                <div class="mark" style="--at: 13.3%">Mata kaki</div>
                <div class="mark" style="--at: 33.3%">Lutut</div>
                <div class="mark" style="--at: 66.7%">Pinggang</div>
                <div class="mark" style="--at: 86.7%">Dada</div>
            </div>
            <p class="gauge-cap" aria-live="polite">Kategori: <strong id="kategori-teks">belum diisi</strong></p>
        </aside>
    </div>
@endsection

@push('scripts')
    {{-- JavaScript dituliskan langsung di view melalui tag <script> --}}
    <script>
        (function () {
            var input  = document.getElementById('tinggi');
            var gauge  = document.getElementById('gauge');
            var teks   = document.getElementById('kategori-teks');
            var form   = document.getElementById('form-lapor');
            var tombol = document.getElementById('btn-kirim');
            var SKALA_MAKS = 150; // tinggi tabung dalam cm

            // Batas kategori sama dengan method kategori() di controller
            function kategori(cm) {
                if (cm >= 120) return 'Sangat tinggi';
                if (cm >= 70)  return 'Tinggi';
                if (cm >= 30)  return 'Sedang';
                return 'Rendah';
            }

            function perbarui() {
                var cm = parseInt(input.value, 10);
                if (isNaN(cm) || cm < 1) {
                    gauge.style.setProperty('--level', '0%');
                    teks.textContent = 'belum diisi';
                    return;
                }
                gauge.style.setProperty('--level', (Math.min(cm, SKALA_MAKS) / SKALA_MAKS * 100) + '%');
                teks.textContent = kategori(cm) + ' (' + cm + ' cm)';
            }

            input.addEventListener('input', perbarui);
            perbarui();

            // Cegah kirim ganda
            form.addEventListener('submit', function () {
                tombol.disabled = true;
                tombol.textContent = 'Mengirim...';
            });
        })();
    </script>
@endpush
