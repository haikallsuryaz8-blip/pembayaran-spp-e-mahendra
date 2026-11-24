<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran SPP - #{{ $pembayaran->id_pembayaran }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #111; margin: 20px; }
        .receipt { max-width: 450px; margin: auto; border: 1px dashed #444; padding: 20px; }
        .header { text-align: center; border-bottom: 1px dashed #444; padding-bottom: 10px; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 2px 0; font-size: 11px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .divider { border-bottom: 1px dashed #444; margin: 12px 0; }
        .total { font-size: 15px; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            .receipt { border: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center; margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Kuitansi
        </button>
    </div>

    <div class="receipt">
        <div class="header">
            <h2>PEMBAYARAN SPP INFINITY</h2>
            <p>SMK JAKARTA PUSAT 1 • BUKTI PEMBAYARAN RESMI</p>
            <p>No. Kuitansi: #SPP-{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="row">
            <span>Tanggal Bayar:</span>
            <span>{{ date('d-m-Y H:i', strtotime($pembayaran->created_at)) }}</span>
        </div>
        <div class="row">
            <span>NISN / NIS:</span>
            <span>{{ $pembayaran->nisn }} / {{ $pembayaran->siswa->nis ?? '-' }}</span>
        </div>
        <div class="row">
            <span>Nama Siswa:</span>
            <span><strong>{{ $pembayaran->siswa->nama ?? '-' }}</strong></span>
        </div>
        <div class="row">
            <span>Kelas / Jurusan:</span>
            <span>{{ $pembayaran->siswa->kelas->nama_kelas ?? '-' }}</span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>Pembayaran Untuk:</span>
            <span><strong>SPP Bulan {{ $pembayaran->bulan_dibayar }} {{ $pembayaran->tahun_dibayar }}</strong></span>
        </div>
        <div class="row">
            <span>Tarif SPP:</span>
            <span>Tahun {{ $pembayaran->spp->tahun ?? '-' }}</span>
        </div>

        <div class="divider"></div>

        <div class="row total">
            <span>TOTAL DIBAYAR:</span>
            <span>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
        </div>
        <div class="row" style="font-size: 11px; color: #555;">
            <span>Status:</span>
            <span>LUNAS</span>
        </div>

        <div class="divider"></div>

        <div class="row" style="margin-top: 15px;">
            <div style="text-align: center; width: 45%;">
                Siswa,<br><br><br>
                ({{ $pembayaran->siswa->nama ?? 'Siswa' }})
            </div>
            <div style="text-align: center; width: 45%;">
                Petugas TU,<br><br><br>
                ({{ $pembayaran->petugas->nama_petugas ?? 'Petugas' }})
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih atas pembayaran tepat waktu.</p>
            <p>Simpan kuitansi ini sebagai bukti pembayaran yang sah.</p>
        </div>
    </div>

</body>
</html>
