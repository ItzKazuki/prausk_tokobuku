<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->code }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }

        .header {
            margin-bottom: 40px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
        }

        .status-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 5px 10px;
            border-radius: 5px;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: bold;
        }

        .info-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .label {
            color: #777;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .items-table th {
            background: #f9fafb;
            border-bottom: 2px solid #eee;
            padding: 12px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .totals {
            float: right;
            width: 300px;
        }

        .totals table {
            width: 100%;
        }

        pweb .totals td {
            padding: 5px 0;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #aaa;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0 40px;
        }


        .action-buttons button,
        .action-buttons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            background: #f3f4f6;
            color: #111;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }


        .action-buttons button:hover,
        .action-buttons a:hover {
            background: #e5e7eb;
        }


        .action-buttons svg {
            width: 16px;
            height: 16px;
            fill: #000;
            /* ICON HITAM */
        }

        @media print {
            .action-buttons {
                display: none;
            }

            .invoice-box {
                border: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td class="logo">KABUKU</td>
                    <td style="text-align: right;">
                        <span class="status-badge">{{ $order->status }}</span><br>
                        <small style="display:block; margin-top:10px; color:#777">Nomor Pesanan:</small>
                        <strong>#{{ $order->code }}</strong>
                    </td>
                </tr>
            </table>
        </div>

        <table class="info-table">
            <tr>
                <td>
                    <span class="label">Penerima:</span>
                    <strong>{{ $order->user->name }}</strong>
                    {{ $order->payment_method }}
                </td>
                <td style="text-align: right;">
                    <span class="label">Tanggal Transaksi:</span>
                    {{ $order->created_at->format('d F Y') }}<br>
                    <span class="label" style="margin-top:10px">Resi:</span>
                    {{ $order->tracking_number ?? 'Belum ada resi' }}
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Buku</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->book->title }} ({{ $item->book->category->name }})</strong><br> <small
                                style="color: #666">ID Produk:
                                {{ $item->book_id }}</small>
                        </td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td style="color:#777">Total Produk</td>
                    <td style="text-align: right;">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="color:#777">Biaya Pengiriman</td>
                    <td style="text-align: right;">Gratis</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr style="border:0; border-top:1px solid #eee">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Grand Total</td>
                    <td style="text-align: right;" class="grand-total">Rp
                        {{ number_format($order->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di KABUKU. Simpan invoice ini sebagai bukti pembelian yang sah.</p>
            <p>Email: support@kabuku.test | Web: www.kabuku.test</p>
        </div>
    </div>

    <div class="action-buttons">
        <button onclick="window.print()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                <path
                    d="M128 128C128 92.7 156.7 64 192 64L405.5 64C422.5 64 438.8 70.7 450.8 82.7L493.3 125.2C505.3 137.2 512 153.5 512 170.5L512 208L128 208L128 128zM64 320C64 284.7 92.7 256 128 256L512 256C547.3 256 576 284.7 576 320L576 416C576 433.7 561.7 448 544 448L512 448L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 448L96 448C78.3 448 64 433.7 64 416L64 320zM192 480L192 512L448 512L448 416L192 416L192 480zM520 336C520 322.7 509.3 312 496 312C482.7 312 472 322.7 472 336C472 349.3 482.7 360 496 360C509.3 360 520 349.3 520 336z" />
            </svg></button>
        <a href="{{ route('invoices.order.download', ['orderNumber' => $order->code]) }}"><svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                <path
                    d="M352 96C352 78.3 337.7 64 320 64C302.3 64 288 78.3 288 96L288 306.7L246.6 265.3C234.1 252.8 213.8 252.8 201.3 265.3C188.8 277.8 188.8 298.1 201.3 310.6L297.3 406.6C309.8 419.1 330.1 419.1 342.6 406.6L438.6 310.6C451.1 298.1 451.1 277.8 438.6 265.3C426.1 252.8 405.8 252.8 393.3 265.3L352 306.7L352 96zM160 384C124.7 384 96 412.7 96 448L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 448C544 412.7 515.3 384 480 384L433.1 384L376.5 440.6C345.3 471.8 294.6 471.8 263.4 440.6L206.9 384L160 384zM464 440C477.3 440 488 450.7 488 464C488 477.3 477.3 488 464 488C450.7 488 440 477.3 440 464C440 450.7 450.7 440 464 440z" />
            </svg></a>
    </div>

</body>

</html>