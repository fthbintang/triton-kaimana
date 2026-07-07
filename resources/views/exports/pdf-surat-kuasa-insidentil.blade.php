<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa Insidentil</title>
    {{-- <style>
        body {
            /* Mengubah font utama menjadi Arial */
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
            margin: 0.5cm 1cm 0.5cm 1cm;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .fw-bold {
            font-weight: bold;
        }

        .judul-surat {
            font-size: 13pt;
            text-decoration: underline;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .table-biodata {
            width: 100%;
            margin-left: 1.5cm;
            margin-bottom: 12px;
            border-collapse: collapse;
        }

        .table-biodata td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .section-khusus {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            letter-spacing: 4px;
            margin-top: 25px;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        /* Layout untuk paragraf bernomor di bagian KHUSUS */
        .poin-khusus {
            margin-left: 0.5cm;
            margin-bottom: 10px;
            text-align: justify;
            position: relative;
            padding-left: 25px;
        }

        .poin-khusus .nomor {
            position: absolute;
            left: 0;
            top: 0;
        }

        /* Memastikan area tanda tangan tidak terpotong ke halaman baru sendirian */
        .wrapper-ttd {
            page-break-inside: avoid;
            margin-top: 35px;
        }

        .table-tanda-tangan {
            width: 100%;
            table-layout: fixed;
        }

        .table-tanda-tangan td {
            text-align: center;
            vertical-align: top;
        }

        .space-ttd {
            height: 75px;
        }

        .wrapper-materai {
            border: 1px dashed #777;
            width: 80px;
            height: 50px;
            margin: 10px auto;
            line-height: 50px;
            font-size: 9pt;
            color: #555;
        }
    </style> --}}

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            /* Diperketat dari 1.5 agar sangat rapat dan hemat kertas */
            color: #000;
            margin: 0.3cm 1cm 0.3cm 1cm;
            /* Margin atas-bawah kertas dipersempit */
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .fw-bold {
            font-weight: bold;
        }

        .judul-surat {
            font-size: 12pt;
            /* Diubah ke 12pt agar proporsional dan hemat ruang */
            text-decoration: underline;
            letter-spacing: 2px;
            margin-bottom: 12px;
            /* Dipangkas dari 25px */
        }

        .table-biodata {
            width: 100%;
            margin-left: 1.2cm;
            /* Sedikit dirapatkan ke kiri */
            margin-bottom: 4px;
            /* Dipangkas dari 12px agar jarak antar baris biodata rapat */
            border-collapse: collapse;
        }

        .table-biodata td {
            padding: 1px 4px;
            /* Padding vertikal diperkecil dari 2px */
            vertical-align: top;
        }

        .section-khusus {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            letter-spacing: 3px;
            margin-top: 10px;
            /* Dipangkas dari 25px */
            margin-bottom: 8px;
            /* Dipangkas dari 15px */
            text-decoration: underline;
        }

        /*
           Layout Poin Khusus diganti ke bentuk tabel murni (di bagian HTML nanti)
           agar nomor dan teks sejajar sempurna di PDF sekaligus tidak berantakan di Word.
        */
        .table-poin-khusus {
            width: 100%;
            margin-bottom: 5px;
            /* Jarak antar nomor dipersempit */
            border-collapse: collapse;
        }

        .table-poin-khusus td {
            padding: 1px 0;
            vertical-align: top;
        }

        /* Memastikan area tanda tangan tidak terpotong ke halaman baru sendirian */
        .wrapper-ttd {
            page-break-inside: avoid;
            margin-top: 15px;
            /* Dipangkas dari 35px */
        }

        .table-tanda-tangan {
            width: 100%;
            border-collapse: collapse;
        }

        .table-tanda-tangan td {
            text-align: center;
            vertical-align: top;
        }

        .space-ttd {
            height: 55px;
            /* Diturunkan dari 75px agar space ttd lebih efisien tapi tetap cukup */
        }

        /* Desain kotak materai yang aman dibaca PDF maupun Word */
        .wrapper-materai {
            border: 1px dashed #bbb;
            width: 75px;
            height: 45px;
            margin: 0 auto;
            line-height: 1.2;
            padding-top: 5px;
            font-size: 6.5pt;
            color: #555;
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="judul-surat" style="text-align: center;">
        <b>SURAT KUASA</b>
    </div>

    <!-- PEMBERI KUASA -->
    <p style="text-indent: 1cm;" class="text-justify">
        Yang bertanda tangan di bawah ini {{ count($data->pemberiKuasa) > 1 ? 'para' : 'saya' }} :
    </p>

    @foreach ($data->pemberiKuasa as $pemberi)
        @if (count($data->pemberiKuasa) > 1)
            <p style="margin-left: 1cm; margin-top: 5px; margin-bottom: 5px;" class="fw-bold">
                {{ $loop->iteration }}. Pemberi Kuasa {{ $loop->iteration }} :
            </p>
        @endif

        <table class="table-biodata">
            <tr>
                <td style="width: 25%;">Nama</td>
                <td style="width: 3%;">:</td>
                <td>{{ $pemberi->nama }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pemberi->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pemberi->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Kebangsaan</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <!-- Ganti baris alamat Anda menjadi seperti ini -->
                <td style="text-align: justify; width: 75%; word-break: break-word; white-space: normal;">
                    {{ $pemberi->alamat }}
                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pemberi->agama }}</td>
            </tr>
        </table>
    @endforeach

    <p class="text-justify" style="margin-top: 10px; margin-bottom: 15px; text-indent: 1cm;">
        Selanjutnya disebut <b>Pemberi Kuasa</b>.
    </p>

    <p style="text-indent: 1cm;" class="text-justify">Dengan ini memberikan kuasa kepada :</p>

    <!-- PENERIMA KUASA -->
    @foreach ($data->penerimaKuasa as $penerima)
        @if (count($data->penerimaKuasa) > 1)
            <p style="margin-left: 1cm; margin-top: 5px; margin-bottom: 5px;" class="fw-bold">
                {{ $loop->iteration }}. Penerima Kuasa {{ $loop->iteration }} :
            </p>
        @endif

        <table class="table-biodata">
            <tr>
                <td style="width: 25%;">Nama</td>
                <td style="width: 3%;">:</td>
                <td>{{ $penerima->nama }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $penerima->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $penerima->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Kebangsaan</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td style="text-align: justify; width: 75%; word-break: break-word; white-space: normal;">
                    {{ $penerima->alamat }}
                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $penerima->agama }}</td>
            </tr>
        </table>
    @endforeach

    <p class="text-justify" style="margin-top: 10px; margin-bottom: 15px; text-indent: 1cm;">
        Selanjutnya disebut <b>Penerima Kuasa</b>.
    </p>

    <!-- SECTION KHUSUS -->
    <div class="section-khusus">KHUSUS</div>

    <!-- Menggunakan tabel murni agar penomoran 100% sejajar dan aman di Word & PDF -->
    <table class="table-poin-khusus">
        <tr>
            <td style="width: 25px; text-align: left;">1.</td>
            <td class="text-justify">
                Bertindak untuk kepentingan Pemberi Kuasa, dalam Perkara
                {{ ucfirst($data->sifat_perkara) }}
                yang akan diajukan pada Pengadilan Negeri Kaimana;
            </td>
        </tr>
    </table>

    <table class="table-poin-khusus">
        <tr>
            <td style="width: 25px; text-align: left;">2.</td>
            <td class="text-justify">
                Untuk mengajukan, menerima, menghadiri persidangan di Pengadilan Negeri Kaimana, dan menandatangani
                surat-surat permohonan, mengajukan bukti-bukti surat, saksi-saksi, memberikan segala keterangan yang
                diperlukan, meminta putusan dan atau penetapan-penetapan.
            </td>
        </tr>
    </table>

    <!-- Paragraf penutup dibuat sangat rapat dengan margin atas-bawah minimal -->
    <p class="text-justify" style="text-indent: 1cm; margin-top: 6px; margin-bottom: 4px;">
        Bahwa dengan tegasnya kepada Penerima Kuasa diberi Hak dan Wewenang penuh untuk menggunakan yang diperlukan demi
        kepentingan Pemberi Kuasa;
    </p>

    <p class="text-justify" style="text-indent: 1cm; margin-top: 0; margin-bottom: 0;">
        Kuasa ini diberikan dengan hak substitusi (baik sebagian atau seluruhnya).
    </p>

    <!-- Kumpulan Tanda Tangan Dibungkus CSS Pencegah Potong Halaman -->
    <div class="ttd-container" style="margin-top: 30px; page-break-inside: avoid;">
        <!-- Bagian Kota & Tanggal Surat -->
        <table style="width: 100%; border: none;" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: right; padding-right: 2cm; font-size: {{ $fontSize ?? '12pt' }};">
                    Kaimana, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <!-- Bagian Utama Kolom Tanda Tangan -->
        <table
            style="width: 100%; margin-top: 15px; border: none; font-size: {{ $fontSize ?? '12pt' }}; border-collapse: collapse;"
            border="0" cellspacing="0" cellpadding="0">

            <!-- BARIS JUDUL JABATAN -->
            <tr>
                <td style="width: 44%; text-align: center; font-weight: bold; padding-bottom: 10px;">Penerima Kuasa,
                </td>
                <td style="width: 12%;"></td> <!-- Penyeimbang ruang tengah -->
                <td style="width: 44%; text-align: center; font-weight: bold; padding-bottom: 10px;">Pemberi Kuasa,</td>
            </tr>

            @php
                // Cari tahu jumlah baris terbanyak
                $maxRows = max(count($data->penerimaKuasa), count($data->pemberiKuasa));
            @endphp

            <!-- BARIS TANDA TANGAN DAN NAMA TERANG -->
            @for ($i = 0; $i < $maxRows; $i++)
                @php
                    $penerima = $data->penerimaKuasa->get($i);
                    $pemberi = $data->pemberiKuasa->get($i);
                @endphp

                <!-- 1. Baris Ruang Kosong Tempat Tanda Tangan -->
                <tr>
                    <td style="height: 70px; text-align: center; vertical-align: middle;">
                        <!-- Area kosong tanda tangan penerima -->
                    </td>

                    <!-- KOLOM TENGAH: Materai disisipkan tepat di antara ttd baris pertama ($i === 0) -->
                    <td style="vertical-align: middle; text-align: center; position: relative;">
                        @if ($i === 0)
                            <table
                                style="width: 90%; margin: 0 auto; border: 1px dashed #bbb; padding: 5px 2px; background-color: #fff; text-align: center;"
                                align="center" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="font-size: 7pt; color: #666; font-family: sans-serif; line-height: 1.2; text-align: center;"
                                        align="center">
                                        MATERAI<br>10.000
                                    </td>
                                </tr>
                            </table>
                            <div style="font-size: 6pt; color: #888; margin-top: 3px; line-height: 1.1; text-align: center;"
                                align="center">
                                Kena Ttd
                            </div>
                        @endif
                    </td>

                    <td style="height: 70px; text-align: center; vertical-align: middle;">
                        <!-- Area kosong tanda tangan pemberi -->
                    </td>
                </tr>

                <!-- 2. Baris Nama Terang Bergaris Bawah -->
                <tr>
                    <td style="text-align: center; vertical-align: top; padding-bottom: 25px;">
                        @if ($penerima)
                            <span>{{ $penerima->nama }}</span>
                        @endif
                    </td>

                    <td></td> <!-- Jeda kolom tengah -->

                    <td style="text-align: center; vertical-align: top; padding-bottom: 25px;">
                        @if ($pemberi)
                            <span>{{ $pemberi->nama }}</span>
                        @endif
                    </td>
                </tr>
            @endfor
        </table>
    </div>

</body>

</html>
