<!DOCTYPE html>
<html>
<head>
    <title>Laporan Gabungan Jayusman Bangunan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .total-box { font-size: 16px; font-weight: bold; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Jayusman Bangunan</h2>
        <p>Laporan Transaksi & Stok Gabungan Seluruh Cabang</p>
        <p>Periode: {{ $start_date->format('d M Y') }} - {{ $end_date->format('d M Y') }}</p>
    </div>

    <div class="total-box">
        Total Pendapatan: Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
    </div>

    <h3>Rekap Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cabang</th>
                <th>Kasir</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->cabang->nama ?? 'Pusat' }}</td>
                <td>{{ $trx->user->name }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Rekap Stok Opname</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cabang</th>
                <th>Barang</th>
                <th>Status</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opnames as $index => $op)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $op->cabang->nama ?? 'Pusat' }}</td>
                <td>{{ $op->barang->nama }}</td>
                <td>{{ $op->keterangan ?? 'Normal' }}</td>
                <td>{{ $op->user->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>