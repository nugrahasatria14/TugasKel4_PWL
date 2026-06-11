<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $transaksi->kode_transaksi }}</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000000;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-sm { font-size: 14px; }
        .text-xs { font-size: 12px; }
        .uppercase { text-transform: uppercase; }
        .mb-2 { margin-bottom: 10px; }
        .mb-4 { margin-bottom: 20px; }
        .mt-4 { margin-top: 20px; }

        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            vertical-align: top;
            font-size: 12px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-weight: bold;
            border-radius: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            border: none;
            font-size: 14px;
        }

        .btn-print { background-color: #4f46e5; color: white; }
        .btn-pdf { background-color: #ef4444; color: white; }
        .btn-back { border: 1px solid #d1d5db; background-color: white; color: #374151; }

        @if(isset($is_pdf))
            @page { margin: 10px; }

            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
            }

            .struk-container {
                width: 100%;
                padding: 0;
                margin: 0;
                box-shadow: none;
            }
        @else
            body {
                background-color: #f3f4f6;
                padding: 20px;
                display: flex;
                justify-content: center;
            }

            .struk-container {
                background-color: #ffffff;
                width: 80mm;
                padding: 15px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            }
        @endif

        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            html, body {
                width: 80mm;
                background-color: #ffffff;
                margin: 0;
                padding: 0;
            }

            .struk-container {
                width: 80mm !important;
                padding: 5mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="struk-container">

        <div class="text-center mb-2">
            <div class="font-bold uppercase text-sm">{{ $transaksi->cabang->nama ?? 'Jayusman Bangunan' }}</div>
            <div class="text-xs">{{ $transaksi->cabang->alamat ?? 'Cabang Utama' }}</div>
        </div>

        <div class="divider"></div>

        <div class="mb-2">
            <table>
                <tr>
                    <td class="text-left">No</td>
                    <td class="text-right">{{ $transaksi->kode_transaksi }}</td>
                </tr>
                <tr>
                    <td class="text-left">Tgl</td>
                    <td class="text-right">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td class="text-left">Kasir</td>
                    <td class="text-right">{{ $transaksi->user->name }}</td>
                </tr>
            </table>
        </div>

        <div class="divider"></div>

        <div class="mb-2">
            <table>
                @foreach($transaksi->details as $detail)
                <tr>
                    <td colspan="2" class="font-bold text-left" style="padding-top: 5px;">
                        {{ $detail->barang->nama }}
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        {{ $detail->qty }} x {{ number_format($detail->harga_saat_transaksi, 0, ',', '.') }}
                    </td>
                    <td class="text-right font-bold">
                        {{ number_format($detail->qty * $detail->harga_saat_transaksi, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="divider"></div>

        <table class="mb-4">
            <tr>
                <td class="text-left font-bold text-sm">TOTAL</td>
                <td class="text-right font-bold text-sm">
                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div class="text-center text-xs mb-4">
            <p style="margin: 2px 0;">Terima kasih atas kunjungan Anda!</p>
            <p style="margin: 2px 0;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
        </div>

        @if(!isset($is_pdf))
        <div class="no-print mt-4">
            <button onclick="window.print()" class="btn btn-print">Cetak Printer</button>
            <a href="{{ route('transaksi.struk.pdf', $transaksi->id) }}" class="btn btn-pdf">Download PDF</a>
            <a href="{{ route('transaksi.create') }}" class="btn btn-back">Kembali ke Kasir</a>
        </div>
        @endif

    </div>

</body>
</html>