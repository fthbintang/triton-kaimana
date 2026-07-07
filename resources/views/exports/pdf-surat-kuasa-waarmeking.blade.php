<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa Waarmeking</title>
    <style>
        /* CSS Setup Kerapatan & Aturan Halaman */
        @page {
            /* Ukuran standar F4 / Folio Indonesia: 21.5cm x 33cm (atau 8.5 x 13 inci) */
            size: 21.5cm 33cm;

            /* Margin disesuaikan agar proporsional dan tidak mudah terpotong */
            margin: 1.5cm 2cm 1.5cm 2.5cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: {{ $fontSize ?? '11pt' }};
            line-height: 1.4;
            /* Jarak spasi kalimat dirapatkan sedikit dari 1.5 */
            color: #000;
            margin: 0;
            padding: 0;
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
            letter-spacing: 2px;
            text-decoration: underline;
            margin-bottom: 20px;
            /* Jarak bawah judul dirapatkan */
        }

        /* Pengaturan Kerapatan Tabel Biodata */
        .table-biodata {
            width: 100%;
            margin-bottom: 8px;
            /* Spasi antar blok data dipersempit */
            border-collapse: collapse;
            page-break-inside: avoid;
            /* Mencegah 1 blok biodata terpotong setengah halaman */
        }

        .table-biodata td {
            vertical-align: top;
            padding: 1px 0;
            /* Padding atas bawah super rapat */
        }

        .section-khusus {
            text-align: center;
            font-weight: bold;
            letter-spacing: 3px;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* Mencegah Paragraf Inti Terpotong Nanggung */
        p {
            margin-top: 0;
            margin-bottom: 8px;
            page-break-inside: avoid;
            /* Jika halaman habis, paragraf langsung pindah utuh */
        }

        /* PENGUNCI AREA TANDA TANGAN AGAR TIDAK TERBELAH */
        .ttd-container {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
            /* MUTLAK: Blok TTD tidak akan terpotong ke halaman sebelah */
        }

        .ttd-box-penerima {
            width: 50%;
            float: left;
            text-align: center;
        }

        .ttd-box-pemberi {
            width: 50%;
            float: right;
            text-align: center;
        }

        .space-ttd {
            height: 55px;
            /* Tinggi kolom tanda tangan sedikit dirapatkan */
        }

        .list-pemberi-ttd {
            page-break-inside: avoid;
            margin-bottom: 15px;
            text-align: center;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    {{-- <div class="judul-surat text-center fw-bold">SURAT KUASA</div> --}}
    <h3 style="text-align: center;" align="center">SURAT KUASA</h3>

    @if ($data->pemberiKuasa->count() == 1)
        <p style="text-indent: 1cm;" class="text-justify">Yang bertanda tangan di bawah ini saya :</p>

        @php $pemberiTunggal = $data->pemberiKuasa->first(); @endphp
        <table class="table-biodata" style="margin-left: 1cm; width: 90%;">
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 3%;">:</td>
                <td class="fw-bold">{{ $pemberiTunggal->nama }}</td>
            </tr>
            <!-- TAMBAHAN BARIS NIK UNTUK KEABSAHAN HUKUM -->
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $pemberiTunggal->nik }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pemberiTunggal->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pemberiTunggal->pekerjaan }}</td>
            </tr>
            <tr>
                <td>Kebangsaan</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $pemberiTunggal->alamat }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pemberiTunggal->agama }}</td>
            </tr>
        </table>

        <p style="text-indent: 1cm;" class="text-justify">Dengan ini memberikan kuasa kepada:</p>

        @foreach ($data->penerimaKuasa as $penerima)
            <!-- MENGGANTI status_penerima MENJADI urutan_ahli_waris -->
            <p style="margin-left: 1cm; margin-top: 12px; margin-bottom: 4px;" class="fw-bold">
                {{ $loop->iteration }}. {{ $penerima->urutan_ahli_waris ?? 'Ahli Waris' }} :
            </p>

            <table class="table-biodata" style="margin-left: 1.5cm; width: 85%;">
                <tr>
                    <td style="width: 30%;">Nama</td>
                    <td style="width: 3%;">:</td>
                    <td class="fw-bold">{{ $penerima->nama }}</td>
                </tr>
                <!-- TAMBAHAN BARIS NIK UNTUK PENERIMA KUASA -->
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $penerima->nik }}</td>
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
                    <td>{{ $penerima->alamat }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{ $penerima->agama }}</td>
                </tr>
            </table>
        @endforeach

        <div class="section-khusus">KHUSUS</div>

        <p class="text-justify" style="text-indent: 1cm;">
            Bertindak untuk kepentingan Pemberi Kuasa <span class="fw-bold">{{ $pemberiTunggal->nama }}</span> selaku
            <span class="fw-bold">{{ $data->pemberiKuasa->first()->urutan_ahli_waris ?? 'Ahli Waris' }}</span>, dalam
            mengajukan
            permohonan ahli waris yang akan diajukan pada Pengadilan Negeri Kaimana;
        </p>
    @elseif ($data->pemberiKuasa->count() > 1 && $data->penerimaKuasa->count() == 1)
        <p style="text-indent: 1cm;" class="text-justify">Yang bertanda tangan di bawah ini para Ahli Waris:</p>

        @foreach ($data->pemberiKuasa as $pemberi)
            <p style="margin-left: 1cm; margin-top: 12px; margin-bottom: 4px;" class="fw-bold">
                {{ $loop->iteration }}. {{ $pemberi->urutan_ahli_waris ?? 'Ahli Waris' }} :
            </p>

            <table class="table-biodata" style="margin-left: 1.5cm; width: 85%;">
                <tr>
                    <td style="width: 30%;">Nama</td>
                    <td style="width: 3%;">:</td>
                    <td class="fw-bold">{{ $pemberi->nama }}</td>
                </tr>
                <!-- DISESUAIKAN: MENAMBAHKAN ROW NIK PEMBERI KUASA -->
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $pemberi->nik }}</td>
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
                    <td>{{ $pemberi->alamat }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{ $pemberi->agama }}</td>
                </tr>
            </table>
        @endforeach

        <p class="text-justify" style="margin-left: 1cm; margin-top: 15px; margin-bottom: 20px;">
            Selanjutnya disebut sebagai <b>Pemberi Kuasa</b>.
        </p>

        <p style="text-indent: 1cm;" class="text-justify">Dengan ini memberikan kuasa kepada:</p>

        @php $penerimaTunggal = $data->penerimaKuasa->first(); @endphp
        <!-- DISESUAIKAN: MENAMPILKAN URUTAN STATUS AHLI WARIS PENERIMA TUNGGAL DI ATAS TABEL AGAR JELAS KEDUDUKANNYA -->
        <p style="margin-left: 1.5cm; margin-top: 12px; margin-bottom: 4px;" class="fw-bold">
            {{ $penerimaTunggal->urutan_ahli_waris ?? 'Ahli Waris' }} :
        </p>

        <table class="table-biodata" style="margin-left: 1.5cm; width: 85%;">
            <tr>
                <td style="width: 30%;">Nama</td>
                <td style="width: 3%;">:</td>
                <td class="fw-bold">{{ $penerimaTunggal->nama ?? '' }}</td>
            </tr>
            <!-- DISESUAIKAN: MENAMBAHKAN ROW NIK PENERIMA KUASA -->
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $penerimaTunggal->nik ?? '' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $penerimaTunggal->jenis_kelamin ?? '' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $penerimaTunggal->pekerjaan ?? '' }}</td>
            </tr>
            <tr>
                <td>Kebangsaan</td>
                <td>:</td>
                <td>Indonesia</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $penerimaTunggal->alamat ?? '' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $penerimaTunggal->agama ?? '' }}</td>
            </tr>
        </table>

        <p class="text-justify" style="margin-left: 1cm; margin-top: 15px; margin-bottom: 20px;">
            Selanjutnya disebut sebagai <b>Penerima Kuasa</b>.
        </p>

        <div class="section-khusus">KHUSUS</div>
    @else
        <p style="text-indent: 1cm;" class="text-justify">Yang bertanda tangan di bawah ini para Ahli Waris:</p>

        @foreach ($data->pemberiKuasa as $pemberi)
            <p style="margin-left: 1cm; margin-top: 12px; margin-bottom: 4px;" class="fw-bold">
                {{ $loop->iteration }}. {{ $pemberi->urutan_ahli_waris ?? 'Ahli Waris' }} :
            </p>

            <table class="table-biodata" style="margin-left: 1.5cm; width: 85%;">
                <tr>
                    <td style="width: 30%;">Nama</td>
                    <td style="width: 3%;">:</td>
                    <td class="fw-bold">{{ $pemberi->nama }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $pemberi->nik }}</td>
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
                    <td>{{ $pemberi->alamat }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{ $pemberi->agama }}</td>
                </tr>
            </table>
        @endforeach

        <p class="text-justify" style="margin-left: 1cm; margin-top: 15px; margin-bottom: 20px;">
            Selanjutnya disebut sebagai <b>Pemberi Kuasa</b>.
        </p>

        <p style="text-indent: 1cm;" class="text-justify">Dengan ini memberikan kuasa kepada:</p>

        @foreach ($data->penerimaKuasa as $penerima)
            <p style="margin-left: 1cm; margin-top: 12px; margin-bottom: 4px;" class="fw-bold">
                {{ $loop->iteration }}. {{ $penerima->urutan_ahli_waris ?? 'Ahli Waris' }} :
            </p>

            <table class="table-biodata" style="margin-left: 1.5cm; width: 85%;">
                <tr>
                    <td style="width: 30%;">Nama</td>
                    <td style="width: 3%;">:</td>
                    <td class="fw-bold">{{ $penerima->nama }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $penerima->nik }}</td>
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
                    <td>{{ $penerima->alamat }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{ $penerima->agama }}</td>
                </tr>
            </table>
        @endforeach

        <p class="text-justify" style="margin-left: 1cm; margin-top: 15px; margin-bottom: 20px;">
            Selanjutnya disebut sebagai <b>Penerima Kuasa</b>.
        </p>

        <div class="section-khusus">KHUSUS</div>
    @endif

    <!-- ========================================================================= -->
    <!-- BAGIAN ISI TEXT KHUSUS & KLAUSUL (BERLAKU UNTUK KEDUA CASE)                -->
    <!-- ========================================================================= -->
    @if ($data->pemberiKuasa->count() > 1)
        <p class="text-justify" style="text-indent: 1cm;">
            Dalam hal ini Penerima Kuasa dikuasakan oleh Pemberi Kuasa untuk menerima, mengajukan, menghadiri segala
            urusan di Pengadilan Negeri Kaimana, dan menandatangani surat-surat permohonan, mengajukan bukti-bukti
            surat, memberikan segala keterangan yang diperlukan, dan meminta penetapan-penetapan.
        </p>
    @else
        <p class="text-justify" style="text-indent: 1cm;">
            Dalam hal ini Penerima Kuasa dikuasakan oleh Pemberi Kuasa untuk menerima, mengajukan, menghadiri segala
            urusan di Pengadilan Negeri Kaimana, dan menandatangani surat-surat permohonan, mengajukan bukti-bukti
            surat, memberikan segala keterangan yang diperlukan, dan meminta penetapan-penetapan.
        </p>
    @endif

    <p class="text-justify" style="text-indent: 1cm;">
        Bahwa dengan tegasnya kepada Penerima Kuasa diberi Hak dan Wewenang penuh untuk menggunakan yang diperlukan demi
        kepentingan Pemberi Kuasa;
    </p>
    <p class="text-justify" style="text-indent: 1cm;">
        Kuasa ini diberikan dengan hak subtitusi (baik sebagian atau seluruhnya).
    </p>

    <!-- ========================================================================= -->
    <!-- AREA SIGNATURE / TANDA TANGAN (PAS DIATUR OTOMATIS)                        -->
    <!-- ========================================================================= -->
    <div class="ttd-container" style="margin-top: 30px;">
        <table style="width: 100%; border: none;" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: right; padding-right: 2cm; font-size: {{ $fontSize ?? '12pt' }};">
                    Kaimana, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 15px; border: none; font-size: {{ $fontSize ?? '12pt' }};"
            border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 44%; text-align: center; vertical-align: top;" align="center">
                    <div style="margin-bottom: 75px;">Penerima Kuasa,</div>

                    @foreach ($data->penerimaKuasa as $penerima)
                        <div style="margin-bottom: 75px;">
                            <span style="font-weight: bold; text-decoration: underline;">{{ $penerima->nama }}</span>
                        </div>
                    @endforeach
                </td>

                <td style="width: 12%; text-align: center; vertical-align: top; padding-top: 25px;" align="center">
                    <table
                        style="width: 100%; border: 1px dashed #bbb; padding: 6px 2px; background-color: #fff; text-align: center;"
                        align="center" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="font-size: 7pt; color: #666; font-family: sans-serif; line-height: 1.2; text-align: center;"
                                align="center">
                                MATERAI<br>10.000
                            </td>
                        </tr>
                    </table>
                    <div style="font-size: 6pt; color: #888; margin-top: 4px; line-height: 1.1; text-align: center;"
                        align="center">
                        Kena Ttd
                    </div>
                </td>

                <td style="width: 44%; text-align: center; vertical-align: top;" align="center">
                    <div style="margin-bottom: 75px;">Pemberi Kuasa,</div>

                    @foreach ($data->pemberiKuasa as $pemberi)
                        <div style="margin-bottom: 75px;">
                            <span style="font-weight: bold; text-decoration: underline;">{{ $pemberi->nama }}</span>
                        </div>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
