<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Permohonan Kuasa Insidentil - {{ $permohonan->nama_pemohon }}</title>
    <style>
        /* Pengaturan Kertas F4 / Folio Rapat */
        @page {
            size: 8.5in 13in;
            margin: 0.6in 0.8in 0.5in 0.8in;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: {{ $fontSize ?? '11pt' }};
            line-height: {{ $lineHeight ?? '1.25' }};
            color: #000;
            background-color: #fff;
        }

        /* Helper Alignment */
        .text-justify {
            text-align: justify;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        /* Layout Header & Komponen Utama */
        .header-perihal,
        .table-tujuan,
        .table-ttd {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-perihal td,
        .table-tujuan td,
        .table-ttd td {
            padding: 0px !important;
            vertical-align: top;
        }

        /* Tabel Data Identitas Super Rapat */
        .table-data {
            width: 100%;
            margin-top: 0px;
            margin-bottom: 0px;
            border-collapse: collapse;
        }

        .table-data td {
            vertical-align: top;
            padding-top: {{ $tableSpacing ?? '1px' }} !important;
            padding-bottom: {{ $tableSpacing ?? '1px' }} !important;
            padding-left: 0px !important;
            padding-right: 0px !important;
            line-height: 1.2 !important;
        }

        /* Lebar Kolom Tabel Identitas */
        .col-label {
            width: 24%;
        }

        .col-titik {
            width: 3%;
            text-align: center;
        }

        .col-value {
            width: 73%;
        }

        /* Jarak Paragraf Esai Naratif (Gunakan em/cm agar dipatuhi Word) */
        p {
            margin-top: 0;
            margin-bottom: 6px;
            text-indent: 1cm;
        }

        .no-indent {
            text-indent: 0px !important;
        }

        /* Daftar Lampiran */
        ol.lampiran {
            margin-top: 0px;
            margin-bottom: 6px;
            padding-left: 2ch;
        }

        ol.lampiran li {
            text-align: justify;
            margin-bottom: 1px;
            line-height: 1.2;
        }

        /* Wadah Tanda Tangan Pendekatan Tabel */
        .ttd-box-word {
            width: 100%;
            text-align: center;
        }

        .ttd-space {
            height: 90px;
        }
    </style>
</head>

<body>

    <table class="header-perihal" border="0">
        <tr>
            <td style="width: 10%;">Perihal</td>
            <td style="width: 3%; text-align: center;">:</td>
            <td style="font-weight: bold; width: 52%;">Permohonan Pendaftaran Surat Ijin Kuasa Insidentil</td>
            <td style="width: 35%; text-align: right;">
                Kaimana, {{ \Carbon\Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <br>

    <table class="table-tujuan" border="0">
        <tr>
            <td class="no-indent">
                Kepada Yth.,<br>
                {{ $permohonan->data_spesifik['perkara']['tujuan_pimpinan'] ?? 'Ketua' }} Pengadilan Negeri
                Kaimana<br>
                <strong>
                    Di -</strong>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 25px !important;"><b>Kaimana</b></td>
        </tr>
    </table>

    <br>

    <div class="text-justify no-indent" style="margin-top: 5px; margin-bottom: 2px;">Dengan hormat,</div>
    <div class="text-justify no-indent" style="margin-bottom: 2px;">Yang bertanda tangan dibawah ini:</div>

    <table class="table-data">
        <tr>
            <td class="col-label">Nama</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->nama_pemohon }}</td>
        </tr>
        <tr>
            <td class="col-label">Tempat/Tgl Lahir</td>
            <td class="col-titik">:</td>
            <td class="col-value">
                {{ $permohonan->data_spesifik['penerima']['tempat_lahir'] ?? '-' }},
                {{ isset($permohonan->data_spesifik['penerima']['tanggal_lahir'])? \Carbon\Carbon::parse($permohonan->data_spesifik['penerima']['tanggal_lahir'])->locale('id')->translatedFormat('d F Y'): '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-label">NIK</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->nik_pemohon }}</td>
        </tr>
        <tr>
            <td class="col-label">Alamat</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['penerima']['alamat'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Jenis Kelamin</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['penerima']['jenis_kelamin'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Agama</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['penerima']['agama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Pekerjaan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['penerima']['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Hubungan Keluarga</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['penerima']['hubungan_keluarga'] ?? '-' }}</td>
        </tr>
    </table>

    <div class="text-justify no-indent" style="margin-top: 2px; margin-bottom: 6px;">
        Selanjutnya disebut sebagai <strong>Penerima Kuasa</strong>.
    </div>

    <p class="text-justify" style="margin-bottom: 4px;">
        Dengan ini saya mengajukan permohonan agar dapat menjadi Kuasa Insidentil mewakili:
    </p>

    <table class="table-data">
        <tr>
            <td class="col-label">Nama</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['nama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Tempat/Tgl Lahir</td>
            <td class="col-titik">:</td>
            <td class="col-value">
                {{ $permohonan->data_spesifik['pemberi']['tempat_lahir'] ?? '-' }},
                {{ isset($permohonan->data_spesifik['pemberi']['tanggal_lahir'])? \Carbon\Carbon::parse($permohonan->data_spesifik['pemberi']['tanggal_lahir'])->locale('id')->translatedFormat('d F Y'): '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-label">NIK</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['nik'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Alamat</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['alamat'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Jenis Kelamin</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['jenis_kelamin'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Agama</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['agama'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Pekerjaan</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['pekerjaan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Hubungan Keluarga</td>
            <td class="col-titik">:</td>
            <td class="col-value">{{ $permohonan->data_spesifik['pemberi']['hubungan_keluarga'] ?? '-' }}</td>
        </tr>
    </table>

    <div class="text-justify no-indent" style="margin-top: 2px; margin-bottom: 6px;">
        Selanjutnya disebut sebagai <strong>Pemberi Kuasa</strong>.
    </div>

    <p class="text-justify">
        Untuk beracara pada Pengadilan Negeri Kaimana mewakili Pemberi Kuasa, mewakili kepentingan hukum Pemberi Kuasa
        di persidangan dalam kedudukannya sebagai
        {{ $permohonan->data_spesifik['perkara']['kedudukan_pemberi'] ?? '-' }}
        {{ $permohonan->data_spesifik['perkara']['jenis_perkara'] ?? '-' }}.
    </p>

    <p class="text-justify">
        Kuasa tersebut diberikan dari Pemberi Kuasa kepada saya sebagai Penerima Kuasa karena Pemberi Kuasa tidak dapat
        hadir untuk mengikuti Persidangan dikarenakan
        {{ $permohonan->data_spesifik['perkara']['alasan_tidak_hadir'] ?? '-' }}.
    </p>

    <p class="text-justify">
        Bahwa Pemberi Kuasa memberikan kuasa kepada Penerima Kuasa
        {{ $permohonan->data_spesifik['perkara']['tujuan_kuasa'] ?? '-' }}.
    </p>

    <p class="text-justify" style="margin-bottom: 2px;">
        Sebagai bahan pertimbangan Bapak {{ $permohonan->data_spesifik['perkara']['tujuan_pimpinan'] ?? 'Ketua' }}
        Pengadilan Negeri Kaimana, bersama ini saya lampirkan:
    </p>

    <ol class="lampiran">
        <li>Surat Keterangan Hubungan Keluarga yang dikeluarkan oleh Kelurahan/ Kepala Kampung;</li>
        <li>Surat Kuasa dari Pemberi Kuasa kepada Penerima Kuasa yang ditandatangani di atas meterai;</li>
        <li>Fotokopi KTP Pemberi Kuasa;</li>
        <li>Fotokopi KTP Penerima Kuasa;</li>
    </ol>

    <p class="text-justify">
        Demikian permohonan ini dibuat, atas terkabulnya permohonan ini, diucapkan terima kasih.
    </p>

    <table class="table-ttd" border="0" style="margin-top: 15px;">
        <tr>
            <td style="width: 60%;"></td>

            <td style="width: 40%; text-align: center;">
                <div class="ttd-box-word">
                    <div class="mb-0">Pemohon,</div>
                    <div class="ttd-space"></div>
                    <div style="text-decoration: underline; font-weight: bold;">{{ $permohonan->nama_pemohon }}</div>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
