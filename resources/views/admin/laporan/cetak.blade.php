<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran SPP</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; margin: 30px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 4px 0; font-size: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #777; padding: 7px 10px; text-align: left; }
        th { background-color: #f2f2f2; text-transform: uppercase; font-size: 11px; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #fafafa; }
        .ttd { margin-top: 40px; float: right; text-align: center; width: 220px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen
        </button>
    </div>

    <div class="header">
        <h2>LAPORAN PEMBAYARAN SPP</h2>
        <p>SMK JAKARTA PUSAT 1 • TAHUN AJARAN 2026</p>
        <p style="font-size: 11px;">Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Tanggal Bayar</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Bulan Bayar</th>
                <th>Petugas</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayaran as $index => $p)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($p->tgl_bayar)) }}</td>
                    <td>{{ $p->nisn }}</td>
                    <td><strong>{{ $p->siswa->nama ?? 'Siswa Terhapus' }}</strong></td>
                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $p->bulan_dibayar }} {{ $p->tahun_dibayar }}</td>
                    <td>{{ $p->petugas->nama_petugas ?? 'Petugas' }}</td>
                    <td class="text-right">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data transaksi pembayaran</td>
                </tr>
            @endforelse
        </tbody>
        @if(count($pembayaran) > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="7" class="text-right">TOTAL PENERIMAAN:</td>
                    <td class="text-right">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="ttd">
        <p>Jakarta, {{ date('d F Y') }}<br>Kepala Bagian Keuangan,</p>
        <br><br><br>
        <p><strong>( .................................................. )</strong></p>
    </div>

</body>
</html>
