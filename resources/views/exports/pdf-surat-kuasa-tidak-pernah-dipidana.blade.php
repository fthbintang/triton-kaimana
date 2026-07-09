<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa Keterangan Tidak Pernah Dipidana</title>
    <style>
        /* Pengaturan Ukuran Kertas F4 Standard (Kepaniteraan Hukum) */
        @page {
            size: 215mm 330mm;
            /* Ukuran presisi F4 */
            margin: 3.5cm 2.5cm 2.5cm 2.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: {{ $fontSize ?? '12pt' }};
            line-height: {{ $lineHeight ?? '1.5' }};
            color: #000000;
            margin: 0;
            padding: 0;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14pt;
            letter-spacing: 0.5px;
            margin-bottom: 35px;
            /* Jarak langsung ke isi karena nomor dihapus */
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        table.table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: {{ $tableSpacing ?? '15px' }};
        }

        table.table-data td {
            padding: 4px 0;
            vertical-align: top;
        }

        .col-label {
            width: 30%;
        }

        .col-strip {
            width: 3%;
            text-align: center;
        }

        .col-value {
            width: 67%;
        }

        .paragraf {
            text-align: justify;
            text-indent: 40px;
            margin-bottom: 15px;
        }

        /* Area Tanda Tangan Kompak Bersilang */
        .table-ttd {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
            position: relative;
        }

        .table-ttd td {
            text-align: center;
            vertical-align: top;
        }

        /* Pembagian kolom kiri, tengah (meterai), kanan */
        .col-ttd-penerima {
            width: 40%;
        }

        .col-ttd-meterai {
            width: 20%;
            vertical-align: middle !important;
        }

        .col-ttd-pemberi {
            width: 40%;
        }

        .space-ttd {
            height: 85px;
            /* Ruang kosong untuk tanda tangan fisik */
        }

        .materai-box {
            border: 1px dashed #555555;
            padding: 18px 5px;
            font-size: 8pt;
            font-weight: bold;
            color: #444444;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.3;
            width: 85px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- JUDUL SURAT -->
    <div class="judul-surat">Surat Kuasa</div>

    <p>Yang bertanda tangan di bawah ini:</p>

    <!-- PEMBERI KUASA -->
    @foreach ($data->pemberiKuasa ?? [] as $index => $pemberi)
        @if (($data->pemberiKuasa ? count($data->pemberiKuasa) : 0) > 1)
            <div class="section-title">PEMBERI KUASA {{ $index + 1 }}:</div>
        @endif
        <table class="table-data">
            <tr>
                <td class="col-label">Nama Lengkap</td>
                <td class="col-strip">:</td>
                <td class="col-value"><strong>{{ strtoupper($pemberi->nama ?? '') }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIK / No. KTP</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $pemberi->nik ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis Kelamin</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $pemberi->jenis_kelamin ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Agama</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $pemberi->agama ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $pemberi->pekerjaan ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat Lengkap</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $pemberi->alamat ?? '' }}</td>
            </tr>
        </table>
    @endforeach

    <p>Selanjutnya disebut <strong>Pemberi Kuasa</strong>.</p>

    <p>Dengan ini memilih domisili hukum di kediaman Penerima Kuasa tersebut di bawah ini, memberikan kuasa penuh
        kepada:</p>

    <!-- PENERIMA KUASA -->
    @foreach ($data->penerimaKuasa ?? [] as $index => $penerima)
        @if (($data->penerimaKuasa ? count($data->penerimaKuasa) : 0) > 1)
            <div class="section-title">PENERIMA KUASA {{ $index + 1 }}:</div>
        @endif
        <table class="table-data">
            <tr>
                <td class="col-label">Nama Lengkap</td>
                <td class="col-strip">:</td>
                <td class="col-value"><strong>{{ strtoupper($penerima->nama ?? '') }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIK / No. KTP</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $penerima->nik ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Jenis Kelamin</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $penerima->jenis_kelamin ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Agama</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $penerima->agama ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Pekerjaan</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $penerima->pekerjaan ?? '' }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat Lengkap</td>
                <td class="col-strip">:</td>
                <td class="col-value">{{ $penerima->alamat ?? '' }}</td>
            </tr>
        </table>
    @endforeach

    <p>Selanjutnya disebut <strong>Penerima Kuasa</strong>.</p>

    <!-- KHUSUS -->
    <div class="judul-surat" style="font-size: 12pt; margin-top: 25px; margin-bottom: 15px;">--- KHUSUS ---</div>

    <p class="paragraf">
        Untuk dan atas nama Pemberi Kuasa, bertindak sendiri-sendiri maupun bersama-sama guna mengurus, mengajukan
        permohonan, menandatangani formulir, serta mengambil berkas <strong>Surat Keterangan Tidak Pernah
            Dipidana</strong> pada Kantor Pengadilan Negeri Kaimana.
    </p>

    <p class="paragraf">
        Untuk maksud tersebut di atas, Penerima Kuasa berhak menghadap petugas dan pejabat berwenang di Pengadilan
        Negeri Kaimana, memberikan keterangan, menunjukkan dan menyerahkan dokumen kelengkapan berkas, serta melakukan
        segala tindakan hukum yang dianggap baik, penting, dan perlu demi tercapainya tujuan pemberian kuasa ini.
    </p>

    <p class="paragraf">
        Surat kuasa ini diberikan dengan hak substitusi (baik sebagian maupun seluruhnya) kepada orang lain untuk
        bertindak sebagai pengganti Penerima Kuasa.
    </p>

    <!-- TANDA TANGAN DINAMIS (MULTI-USER DENGAN 1 METERAI DI ATAS) -->
    <table class="table-ttd">
        <tr>
            <td class="col-ttd-penerima"></td>
            <td class="col-ttd-meterai"></td>
            <td class="col-ttd-pemberi">Kaimana, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="col-ttd-penerima"><strong>PENERIMA KUASA,</strong></td>
            <td class="col-ttd-meterai"></td>
            <td class="col-ttd-pemberi"><strong>PEMBERI KUASA,</strong></td>
        </tr>

        @php
            $totalPemberi = count($data->pemberiKuasa ?? []);
            $totalPenerima = count($data->penerimaKuasa ?? []);
            $maxBaris = max($totalPemberi, $totalPenerima);
        @endphp

        @for ($i = 0; $i < $maxBaris; $i++)
            @php
                $pemberi = $data->pemberiKuasa[$i] ?? null;
                $penerima = $data->penerimaKuasa[$i] ?? null;
            @endphp

            <!-- Ruang Kosong Tanda Tangan Basah -->
            <tr>
                <td class="space-ttd"></td>
                <td class="space-ttd col-ttd-meterai">
                    <!-- Meterai HANYA muncul sekali di baris pertama (paling atas) -->
                    @if ($i == 0)
                        <div class="materai-box">MATERAI<br>TEMPEL<br>10.000</div>
                    @endif
                </td>
                <td class="space-ttd"></td>
            </tr>

            <!-- Nama Jelas Penandatangan -->
            <tr>
                <td class="col-ttd-penerima" style="padding-bottom: 30px;">
                    @if ($penerima)
                        <u><strong>{{ strtoupper($penerima->nama) }}</strong></u>
                    @endif
                </td>
                <td class="col-ttd-meterai" style="padding-bottom: 30px;"></td>
                <td class="col-ttd-pemberi" style="padding-bottom: 30px;">
                    @if ($pemberi)
                        <u><strong>{{ strtoupper($pemberi->nama) }}</strong></u>
                    @endif
                </td>
            </tr>
        @endfor
    </table>

</body>

</html>
