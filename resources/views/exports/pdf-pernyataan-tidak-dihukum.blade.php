<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Tidak Pernah Dihukum</title>
    <style>
        /* Pengaturan halaman khusus untuk kertas F4 agar presisi di Word & PDF */
        @page Section1 {
            size: 21.5cm 33.0cm;
            margin: 2cm 2cm 2cm 2.5cm;
        }

        div.Section1 {
            page: Section1;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: {{ $fontSize }};
            line-height: {{ $lineHeight }};
            color: #000;
            margin: 0;
            /* WAJIB 0: Mencegah Word mendorong tabel meluber ke kanan */
            padding: 0;
            width: 100%;
        }

        /* Tabel pelindung utama untuk mengunci lebar konten agar tidak meluber */
        .wrapper-table {
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .title-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
            table-layout: fixed;
        }

        .biodata-table {
            width: 100%;
            margin-top: {{ $tableSpacing }};
            margin-bottom: 1.5rem;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .biodata-table td {
            padding: 2px 0;
            vertical-align: top;
            line-height: 1.3;
        }

        .table-ttd {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3rem;
            table-layout: fixed;
        }

        .table-ttd td {
            padding: 0;
            vertical-align: top;
        }

        .kotak-meterai {
            display: inline-block;
            width: 85px;
            height: 50px;
            border: 1px dashed #777;
            font-size: 7pt;
            color: #777;
            text-align: center;
            line-height: 1.2;
            padding-top: 25px;
            box-sizing: border-box;
        }

        .line-nama {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Div pembungkus halaman standar Word XML -->
    <div class="Section1">

        <!-- MASALAH TERPOTONG DIKUNCI DI SINI: Semua konten dibungkus tabel tunggal berukuran fixed -->
        <table class="wrapper-table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>

                    <!-- ====== 1. BAGIAN JUDUL ====== -->
                    <table class="title-container" width="100%">
                        <tr>
                            <td class="text-center"
                                style="font-size: 11pt; line-height: 1.3; padding: 0 0 12px 0; border-bottom: 2.5px solid #000; text-align: center;">
                                <strong>SURAT PERNYATAAN<br>
                                    TIDAK PERNAH DIHUKUM PENJARA DAN/ ATAU<br>
                                    TIDAK SEDANG MENJALANI PROSES HUKUM</strong>
                            </td>
                        </tr>
                    </table>

                    <!-- ====== 2. PARAGRAF PEMBUKA ====== -->
                    <p style="margin-top: 1.5rem; margin-bottom: 1rem;">Yang bertandatangan di bawah ini :</p>

                    <!-- ====== 3. TABEL BIODATA ====== -->
                    <table class="biodata-table" width="100%">
                        <tr>
                            <td style="width: 25%;">Nama</td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 72%;">{{ $permohonan->nama_pemohon }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $permohonan->data_spesifik['pemohon']['jenis_kelamin'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tempat, Tgl. Lahir</td>
                            <td>:</td>
                            <td>
                                {{ $permohonan->data_spesifik['pemohon']['tempat_lahir'] ?? '-' }},
                                {{ isset($permohonan->data_spesifik['pemohon']['tanggal_lahir'])? \Carbon\Carbon::parse($permohonan->data_spesifik['pemohon']['tanggal_lahir'])->locale('id')->translatedFormat('d F Y'): '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>Pekerjaan / Jabatan</td>
                            <td>:</td>
                            <td>
                                {{ $permohonan->data_spesifik['pemohon']['pekerjaan'] ?? '-' }}
                                @if (
                                    !empty($permohonan->data_spesifik['pemohon']['jabatan']) &&
                                        $permohonan->data_spesifik['pemohon']['jabatan'] !== '-')
                                    / {{ $permohonan->data_spesifik['pemohon']['jabatan'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td class="text-justify">{{ $permohonan->data_spesifik['pemohon']['alamat'] ?? '-' }}</td>
                        </tr>
                    </table>

                    <!-- ====== 4. ISI PERNYATAAN ====== -->
                    <p class="text-justify" style="margin-bottom: 1.5rem;">
                        Menyatakan dengan sebenarnya bahwa saya tidak pernah dihukum penjara karena melakukan tindak
                        pidana kejahatan
                        dan/atau tidak sedang dalam menjalani proses hukum pidana.
                    </p>

                    <p class="text-justify" style="margin-bottom: 1.5rem;">
                        Demikian surat pernyataan ini dibuat dengan sebenarnya untuk dapat digunakan sebagai bukti
                        pemenuhan syarat
                        pengurusan surat keterangan tidak pernah terpidana dari Pengadilan Negeri Kaimana.
                    </p>

                    <!-- ====== 5. AREA TANDA TANGAN ====== -->
                    <table class="table-ttd" width="100%">
                        <tr>
                            <!-- Kolom kiri bertindak sebagai spacer mendorong ttd ke kanan resmi -->
                            <td style="width: 55%;"></td>

                            <!-- Kolom kanan menampung info TTD asli -->
                            <td style="width: 45%; text-align: left;">
                                <strong>Dibuat di : Kaimana<br>
                                    Pada Tanggal :
                                    {{ \Carbon\Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d F Y') }}</strong>
                                <br><br>

                                <div class="text-center" style="width: 100%; text-align: center;">
                                    <strong>Yang membuat Pernyataan,</strong>
                                    <br><br>

                                    <!-- Kotak Meterai diposisikan menggunakan tabel mini pendukung -->
                                    <table width="100%"
                                        style="border-collapse: collapse; margin-top: 5px; margin-bottom: 15px; table-layout: fixed;">
                                        <tr>
                                            <td style="width: 50%; text-align: left; padding: 0; padding-left: 35%">
                                                <div class="kotak-meterai">
                                                    <strong>METERAI<br>TEMPEL<br>10.000</strong>
                                                </div>
                                            </td>
                                            <td style="width: 50%; padding: 0;"></td>
                                        </tr>
                                    </table>

                                    <strong><span class="line-nama">{{ $permohonan->nama_pemohon }}</span></strong>
                                </div>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>

    </div>
</body>

</html>
