<!DOCTYPE html>
<html>
    <head>
        <title>Transaction Receipt</title>
        <meta charset="UTF-8">

        <style>
            table tr td,
            th {
                font-size: 11px;
            }
            
            table {
                width: 100%;
            }

            @page { margin-left: 20px; margin-right: 20px; margin-bottom: 0px; }
        </style>
    </head>
    <body>
        <div class="container">
            <center>
                <h4>Harmony Market</h4>
                <p style="font-size: 12px;">
                    Jl. Mawar No. 16, Tanjung Pinang<br>
                    Indonesia
                </p>

                <br>

                <table style="text-align: center;">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: left; font-weight: none;">No# {{ $invoiceObj->invoice_no }}</th>
                            <th style="font-weight: none; text-align: right;">{{ \Carbon\Carbon::parse(now())->format('h:i:s') }}</th>
                            <th style="font-weight: none; text-align: right;">{{ \Carbon\Carbon::parse(now())->format('d/m/Y') }}</th>
                        </tr>
                        <tr>
                            <th style="text-align: left; font-weight: none;" colspan="4">=====================================</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($invoiceObj->hsInvoiceDetail as $itemDetail)
                            <tr>
                                <td colspan="4" style="text-align: left;">
                                    {{ $itemDetail->hsItemDetail->name }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;">{{ $itemDetail->quantity }} {{ $itemDetail->hsItemDetail->hsItemUom->name }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X</td>
                                <td style="text-align: right;">{{ number_format($itemDetail->price, 2) }}</td>
                                <td style="text-align: right;">{{ number_format($itemDetail->sub_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th style="text-align: left; font-weight: none;" colspan="4">=====================================</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: right;">TOTAL: </th>
                            <th style="text-align: right;">
                                {{ number_format($invoiceObj->sub_total, 2) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: right;">BAYAR: </th>
                            <th style="text-align: right;">
                                {{ number_format($invoiceObj->paid_amt, 2) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: right;">KEMBALI: </th>
                            <th style="text-align: right;">
                                {{ number_format($invoiceObj->return_amt, 2) }}
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: left; font-weight: none;" colspan="4">=====================================</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="text-center">
                                MOHON DIPERIKSA KEMBALI JUMLAH & TANGGAL KADALUARSA PRODUK YANG DIBELI, JIKA TIDAK SESUAI ATAU RAGU, MOHON DIBERITAHUKAN..!
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </center>
        </div>
    </body>
</html>
