<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP</title>
</head>
<body>
    <table border="1" cellpadding="6" cellspacing="0" style="font-family: Arial, sans-serif; font-size: 11pt;">
        <thead>
            <tr>
                <th colspan="8" style="font-size: 14pt; font-weight: bold; text-align: center; background-color: #e0e7ff;">
                    LAPORAN PEMBAYARAN SPP SISWA
                </th>
            </tr>
            <tr>
                <th colspan="8" style="font-size: 12pt; text-align: center;">
                    SMK JAKARTA PUSAT 1
                </th>
            </tr>
            <tr>
                <th colspan="8" style="font-size: 10pt; text-align: center; color: #555;">
                    Tanggal Unduh: {{ date('d F Y H:i:s') }}
                </th>
            </tr>
            <tr><th colspan="8"></th></tr>
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <th style="border: 1px solid #000; text-align: center;">No</th>
                <th style="border: 1px solid #000; text-align: center;">Tanggal Bayar</th>
                <th style="border: 1px solid #000; text-align: center;">NISN</th>
                <th style="border: 1px solid #000;">Nama Siswa</th>
                <th style="border: 1px solid #000; text-align: center;">Kelas</th>
                <th style="border: 1px solid #000; text-align: center;">Bulan & Tahun Bayar</th>
                <th style="border: 1px solid #000;">Petugas Penerima</th>
                <th style="border: 1px solid #000; text-align: right;">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $p)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ date('d/m/Y', strtotime($p->tgl_bayar)) }}</td>
                    <td style="border: 1px solid #000; text-align: center; mso-number-format:'\@';">'{{ $p->nisn }}</td>
                    <td style="border: 1px solid #000;">{{ $p->siswa->nama ?? 'Siswa Terhapus' }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td style="border: 1px solid #000; text-align: center;">{{ $p->bulan_dibayar }} {{ $p->tahun_dibayar }}</td>
                    <td style="border: 1px solid #000;">{{ $p->petugas->nama_petugas ?? 'Petugas' }}</td>
                    <td style="border: 1px solid #000; text-align: right;" data-format="#,##0">{{ $p->jumlah_bayar }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="border: 1px solid #000; text-align: center; padding: 15px;">
                        Tidak ada data transaksi pembayaran yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($pembayaran) > 0)
            <tfoot>
                <tr style="background-color: #e5e7eb; font-weight: bold;">
                    <td colspan="7" style="border: 1px solid #000; text-align: right;">TOTAL PENERIMAAN KAS:</td>
                    <td style="border: 1px solid #000; text-align: right;" data-format="#,##0">{{ $totalBayar }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>
</html>
