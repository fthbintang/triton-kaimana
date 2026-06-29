<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Waarmeking</title>
    {{-- <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }

        p {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: justify;
        }

        .table-biodata {
            margin-left: 20px;
            margin-bottom: 12px;
        }

        .table-biodata td {
            vertical-align: top;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .label-pemohon {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        ul {
            margin-top: 5px;
            margin-bottom: 5px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 3px;
            text-align: justify;
        }

        /* Wrap tanda tangan agar rapi & tidak pecah berantakan */
        .signature-section {
            margin-top: 30px;
            width: 100%;
        }

        .signature-box {
            text-align: center;
            vertical-align: top;
            padding-bottom: 15px;
        }
    </style> --}}

    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            /* Diubah menjadi dinamis menyesuaikan kepadatan data */
            font-size: {{ $fontSize }};
            line-height: {{ $lineHeight }};
            color: #000;
        }

        p {
            margin-top: 0;
            /* Margin bawah paragraf ikut menyesuaikan spasi tabel */
            margin-bottom: {{ $tableSpacing }};
            text-align: justify;
        }

        .table-biodata {
            margin-left: 20px;
            /* Margin bawah tabel mengikuti kalkulasi backend */
            margin-bottom: {{ $tableSpacing }};
            /* Memastikan tabel tidak pecah aneh di tengah baris data */
            page-break-inside: auto;
        }

        .table-biodata tr {
            /* Mencegah satu baris terpotong terpisah halaman */
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .table-biodata td {
            vertical-align: top;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .label-pemohon {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        ul {
            margin-top: 5px;
            margin-bottom: {{ $tableSpacing }};
            padding-left: 20px;
        }

        li {
            margin-bottom: 3px;
            text-align: justify;
        }

        /* Wrap tanda tangan agar rapi & dipaksa tidak boleh pecah sendirian */
        .signature-section {
            margin-top: 30px;
            width: 100%;
            /* MEMAKSA BLOK TANDA TANGAN TIDAK BOLEH YATIM/TERPOTONG SENDIRIAN DI HALAMAN 2 */
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            vertical-align: top;
            padding-bottom: 15px;
        }
    </style>
</head>

<body>

    <table width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td width="52%" style="vertical-align: top;">
                <table width="100%">
                    <tr>
                        <td width="18%" style="vertical-align: top;">Perihal</td>
                        <td width="5%" style="vertical-align: top;">:</td>
                        <td style="vertical-align: top; font-weight: bold;">
                            Mohon Pengesahan Akta Di Bawah Tangan (Waarmeking) untuk Pencairan Tabungan
                        </td>
                    </tr>
                </table>
            </td>

            <td width="48%" style="vertical-align: top; padding-left: 30px;">
                <p style="margin-bottom: 10px;">
                    Kaimana, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                </p>
                <p style="margin: 0; line-height: 1.4;">
                    Yth. <br>
                    Ketua Pengadilan Negeri Kaimana<br>
                    di – <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;T E M P A T
                </p>
            </td>
        </tr>
    </table>

    @php
        $totalPemohon = 1 + (is_array($pemohon_tambahan) ? count($pemohon_tambahan) : 0);
        $sebutanPemohon = $totalPemohon > 1 ? 'Kami' : 'Saya';
    @endphp

    <p>{{ $sebutanPemohon }} yang bertandatangan dibawah ini:</p>

    @if ($totalPemohon > 1)
        <div class="label-pemohon">PEMOHON I:</div>
    @endif
    <table class="table-biodata" width="100%">
        <tr>
            <td>Hubungan Silsilah</td>
            <td>:</td>
            <td style="font-weight: bold;">{{ $urutan_ahli_waris ?? '-' }}</td>
        </tr>
        <tr>
            <td width="25%">Nama</td>
            <td width="3%">:</td>
            <td>{{ $nama_pemohon }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl. Lahir</td>
            <td>:</td>
            <td>{{ $tempat_lahir }},
                {{ \Carbon\Carbon::parse($tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $pekerjaan }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $agama }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td style="text-align: justify;">{{ $alamat }}</td>
        </tr>
    </table>

    @if (is_array($pemohon_tambahan) && count($pemohon_tambahan) > 0)
        @foreach ($pemohon_tambahan as $index => $pt)
            <div class="label-pemohon" style="margin-top: 3px; margin-bottom: 2px;">PEMOHON {{ $index + 2 }}:</div>

            <table class="table-biodata" width="100%" style="margin-bottom: 5px; line-height: 1.2;">
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Hubungan Silsilah</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px; font-weight: bold;">
                        {{ $pt['urutan_ahli_waris'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td width="25%" style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Nama</td>
                    <td width="3%" style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">
                        {{ $pt['nama'] }}
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Tempat/Tgl. Lahir</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">
                        {{ $pt['tempat_lahir'] ?? '-' }},
                        {{ isset($pt['tanggal_lahir']) ? \Carbon\Carbon::parse($pt['tanggal_lahir'])->locale('id')->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Jenis Kelamin</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">
                        {{ $pt['jenis_kelamin'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Pekerjaan</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">
                        {{ $pt['pekerjaan'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Agama</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">{{ $pt['agama'] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">Alamat</td>
                    <td style="vertical-align: top; padding-top: 1px; padding-bottom: 1px;">:</td>
                    <td style="text-align: justify; vertical-align: top; padding-top: 1px; padding-bottom: 1px;">
                        {{ $pt['alamat'] ?? '-' }}</td>
                </tr>
            </table>
        @endforeach
    @endif

    <p style="margin-top: 15px;">
        Dengan ini datang menghadap Bapak Ketua Pengadilan Negeri Kaimana untuk mohon disahkan sebagai ahli waris dari
        Almarhum {{ $nama_pewaris }} yang berhak mengambil tabungan/deposito di Bank atas nama
        Almarhum
        {{ $nama_pewaris }}

        @if (is_array($daftar_rekening) && count($daftar_rekening) > 0)
            @if (count($daftar_rekening) == 1)
                dengan rincian rekening sebagai berikut:
                <table width="100%"
                    style="margin-left: 20px; margin-top: 5px; margin-bottom: 5px; border-collapse: collapse;">
                    <tr>
                        <td width="3%" style="vertical-align: top;">-</td>
                        <td width="22%" style="vertical-align: top;">Bank</td>
                        <td width="3%" style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">{{ $daftar_rekening[0]['nama_bank'] }}
                            {{ $daftar_rekening[0]['cabang_bank'] }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">Nomor Rekening</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top;">{{ $daftar_rekening[0]['nomor_rekening'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">-</td>
                        <td style="vertical-align: top;">Jumlah Saldo</td>
                        <td style="vertical-align: top;">:</td>
                        <td style="vertical-align: top; text-align: justify;">
                            Rp{{ number_format($daftar_rekening[0]['nominal_angka'], 0, ',', '.') }}
                            (<em>{{ $daftar_rekening[0]['nominal_huruf'] }}</em>)
                        </td>
                    </tr>
                </table>
            @else
                dengan rincian beberapa rekening sebagai berikut:
                @foreach ($daftar_rekening as $index => $rek)
                    <div style="margin-left: 20px; margin-top: 5px; font-weight: bold;">Rekening {{ $index + 1 }}:
                    </div>
                    <table width="100%"
                        style="margin-left: 40px; margin-top: 2px; margin-bottom: 8px; border-collapse: collapse;">
                        <tr>
                            <td width="3%" style="vertical-align: top;">-</td>
                            <td width="22%" style="vertical-align: top;">Bank</td>
                            <td width="3%" style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $rek['nama_bank'] }}
                                {{ $rek['cabang_bank'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">-</td>
                            <td style="vertical-align: top;">Nomor Rekening</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top;">{{ $rek['nomor_rekening'] }}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">-</td>
                            <td style="vertical-align: top;">Jumlah Saldo</td>
                            <td style="vertical-align: top;">:</td>
                            <td style="vertical-align: top; text-align: justify;">
                                Rp{{ number_format($rek['nominal_angka'], 0, ',', '.') }}
                                (<em>{{ $rek['nominal_huruf'] }}</em>)
                            </td>
                        </tr>
                    </table>
                @endforeach
            @endif
        @endif
    </p>

    <p>Sebagai bahan pertimbangan Bapak Ketua Pengadilan Negeri Kaimana, {{ $sebutanPemohon }} telah melampirkan
        pula surat-surat lain yang berhubungan dengan perihal diatas sebagai persyaratan (surat-surat terlampir).</p>

    <p>Demikian permohonan {{ $sebutanPemohon }}, atas perhatian dan bantuan Bapak Ketua Pengadilan Negeri Kaimana
        {{ $sebutanPemohon }} ucapkan terima kasih.</p>

    <table class="signature-section" width="100%">
        <tr>
            <td class="signature-box" width="50%">
            </td>
            <td class="signature-box" width="50%">
                <p style="text-align: center; margin-bottom: 90px;">
                    {{ $totalPemohon > 1 ? 'Pemohon I,' : 'Yang Bermohon,' }}</p>
                <p style="text-align: center;">{{ $nama_pemohon }}</p>
            </td>
        </tr>

        @if (is_array($pemohon_tambahan) && count($pemohon_tambahan) > 0)
            @foreach ($pemohon_tambahan as $index => $pt)
                <tr>
                    <td class="signature-box" width="50%"></td>
                    <td class="signature-box" width="50%">
                        <p style="text-align: center; margin-bottom: 90px;">Pemohon {{ $index + 2 }},</p>
                        <p style="text-align: center;">{{ $pt['nama'] }}</p>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

</body>

</html>
