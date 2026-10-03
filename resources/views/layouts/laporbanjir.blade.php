<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | LaporBanjir BPBD Kabupaten Bandung</title>

    {{-- CSS dituliskan langsung di view melalui tag <style> --}}
    <style>
        :root {
            --ink: #17324D;
            --muted: #506577;
            --water: #00A6A6;
            --water-deep: #007F82;
            --foam: #E9FFF8;
            --paper: #FFFDF8;
            --line: #D7E3E5;
            --rendah: #2EAD65;
            --sedang: #E9A400;
            --tinggi: #FF8A3D;
            --sangat: #F05252;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-padding-top: 1rem;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            color: var(--ink);
            background: linear-gradient(
                rgba(255, 255, 255, 0.18),
                rgba(255, 255, 255, 0.18)
            ), url('/images/background.jpg') center center / cover fixed no-repeat;
            line-height: 1.55;
        }

        .wrap {
            width: min(960px, 100% - 2rem);
            margin-inline: auto;
        }

        .top {
            background: rgba(0, 127, 130, 0.96);
            color: #fff;
        }

        .top .wrap {
            display: flex;
            align-items: baseline;
            gap: .9rem;
            padding: .9rem 0;
            flex-wrap: wrap;
        }

        .brand {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: .01em;
            color: #fff;
            text-decoration: none;
        }

        .top span {
            color: #E9FFFB;
            font-size: .92rem;
        }

        main {
            padding: 2rem 0 3rem;
        }

        h1 {
            font-size: clamp(1.6rem, 4vw, 2.1rem);
            line-height: 1.2;
            margin: 0 0 .5rem;
            color: #123B5D;
            font-weight: 800;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.85);
        }

        .lead {
            color: #36566D;
            margin: 0 0 1.75rem;
            max-width: 60ch;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.9);
        }

        .layout {
            display: grid;
            grid-template-columns: 1fr 230px;
            gap: 2rem;
            align-items: start;
        }

        .card {
            background: rgba(255, 255, 255, 0.97);
            border: 2px solid #FFFFFF;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(23, 50, 77, 0.16);
        }

        /* Form */
        .field {
            margin-bottom: 1.15rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: .3rem;
            color: #17324D;
        }

        .hint {
            display: block;
            font-size: .85rem;
            color: var(--muted);
            font-weight: 400;
        }

        input[type=text],
        input[type=number] {
            width: 100%;
            font: inherit;
            color: inherit;
            padding: .65rem .75rem;
            border: 1px solid #9EC5C8;
            border-radius: 6px;
            background: #fff;
        }

        input:focus-visible,
        button:focus-visible,
        .btn:focus-visible {
            outline: 3px solid #FFD166;
            outline-offset: 2px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .input-unit {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .input-unit input {
            max-width: 150px;
        }

        .input-unit span {
            color: var(--muted);
        }

        .err {
            color: var(--sangat);
            font-size: .88rem;
            margin: .3rem 0 0;
        }

        input.invalid {
            border-color: var(--sangat);
        }

        .alert {
            background: #FFF3D6;
            border: 1px solid #FFD166;
            color: #805B00;
            padding: .75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.25rem;
        }

        .btn {
            display: inline-block;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
            padding: .7rem 1.4rem;
            border-radius: 6px;
            border: 1px solid var(--water-deep);
            background: var(--water-deep);
            color: #fff;
            text-decoration: none;
        }

        .btn:hover {
            background: var(--water);
            border-color: var(--water);
        }

        .btn.ghost {
            background: #fff;
            color: var(--water-deep);
            border-color: var(--water-deep);
        }

        .btn.ghost:hover {
            background: #E9FFF8;
        }

        .btn[disabled] {
            opacity: .65;
            cursor: progress;
        }

        .actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        /* Alat ukur genangan: isi air mengikuti nilai tinggi */
        .gauge {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .gauge .tube {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 70px;
            height: 100%;
            border: 2px solid var(--ink);
            border-top: 0;
            border-radius: 0 0 12px 12px;
            background: #fff;
            overflow: hidden;
        }

        .gauge .fill {
            position: absolute;
            inset: auto 0 0 0;
            height: var(--level, 0%);
            background: var(--water);
            transition: height .35s ease;
        }

        .gauge .mark {
            position: absolute;
            left: 70px;
            bottom: var(--at);
            width: calc(100% - 70px);
            border-bottom: 1px dashed #79AEB2;
            font-size: .8rem;
            color: #17324D;
            padding-left: .5rem;
            line-height: 1;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.95);
        }

        .gauge-cap {
            margin: .75rem 0 0;
            font-size: .9rem;
            color: #17324D;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.95);
        }

        .gauge-cap strong {
            color: var(--ink);
        }

        /* Konfirmasi */
        .badge {
            display: inline-block;
            padding: .2rem .7rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            color: #fff;
            margin-left: .4rem;
        }

        .badge.rendah {
            background: var(--rendah);
        }

        .badge.sedang {
            background: var(--sedang);
        }

        .badge.tinggi {
            background: var(--tinggi);
        }

        .badge.sangat {
            background: var(--sangat);
        }

        dl.data {
            margin: 0;
            display: grid;
            grid-template-columns: 11rem 1fr;
        }

        dl.data dt,
        dl.data dd {
            margin: 0;
            padding: .75rem 0;
            border-bottom: 1px solid var(--line);
        }

        dl.data dt {
            color: var(--muted);
        }

        dl.data dd {
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .notice {
            margin-top: 1.25rem;
            font-size: .9rem;
            color: #287052;
            background: var(--foam);
            border-radius: 6px;
            padding: .75rem 1rem;
            border: 1px solid #B8E8D5;
        }

        .success-title {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .success-title .dot {
            width: .8rem;
            height: .8rem;
            border-radius: 50%;
            background: var(--rendah);
            flex: none;
        }

        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.8);
            color: #17324D;
            font-size: .85rem;
            padding: 1rem 0 2rem;
            background: rgba(255, 255, 255, 0.82);
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
        }

        @media (max-width: 760px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .row {
                grid-template-columns: 1fr;
            }

            .gauge {
                height: 220px;
            }

            dl.data {
                grid-template-columns: 1fr;
            }

            dl.data dt {
                border-bottom: 0;
                padding-bottom: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .gauge .fill {
                transition: none;
            }
        }

        @media print {
            .top,
            .actions,
            footer {
                display: none;
            }

            body {
                background: #fff;
            }
        }
    </style>
</head>
<body>
    <header class="top">
        <div class="wrap">
            <a class="brand" href="{{ route('laporbanjir.form') }}">LaporBanjir</a>
            <span>BPBD Kabupaten Bandung</span>
        </div>
    </header>

    <main class="wrap">
        @yield('content')
    </main>

    <footer>
        <div class="wrap">Prototipe sistem pelaporan banjir. Dalam keadaan darurat, hubungi 112.</div>
    </footer>

    @stack('scripts')
</body>
</html>