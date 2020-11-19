<!DOCTYPE html>
<html>
    <head>
        <title>Transaction Purchase Report</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
        
    <body>
        <div class="container">
            
            <p style="text-align: left; font-weight: bold;">Tanggal Cetak: {{ \Carbon\Carbon::parse(now())->format('m/d/yy') }}</p>

            <center>
                <div style="border-top: 5px double #337ab7; border-bottom: 5px double #337ab7; border-left: 3px solid #337ab7; border-right: 3px solid #337ab7;">
                    <h1 class="text-center text-primary pr-1" 
                    style="text-decoration: underline;">
                        <img src="./img/kasir.png" style="width: 50px;">HARMONY MARKET
                    </h1>

                    <p>
                        Laporan Transaksi Penjualan
                        <br>
                        Periode: {{ \Carbon\Carbon::parse($date_from)->format('m/d/yy') }} - {{ \Carbon\Carbon::parse($date_to)->format('m/d/yy') }}
                    </p>
                </div>

                <hr>
            </center>

            @if (!$dataExist)
                <table class="table-bordered table w-100">
                    <tr>
                        <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Item
                        </td>

                        <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Kuantiti
                        </td>

                        <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Harga
                        </td>

                        <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Total
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center;" colspan="4">
                            Tidak terdapat data pada periode ini.
                        </td>
                    </tr>
                </table>
            @else
                @php $i = 1 @endphp
                @foreach ($listOfHsInvoice as $ivObj)
                <table class="table-bordered table w-100">
                    <tbody>
                        <tr>
                            <td colspan="4" class="bg-primary text-white" style="font-weight: bold; text-decoration: underline;">
                                {{ \Carbon\Carbon::parse($ivObj->invoice_datetime)->format('yy/m/d') }} - ({{ $ivObj->invoice_no }})
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                Item
                            </td>

                            <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                Kuantiti
                            </td>

                            <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                Harga
                            </td>

                            <td class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                Total
                            </td>
                        </tr>

                        @foreach ($ivObj->hsInvoiceDetail as $invoiceDetail)
                            <tr>
                                <td>
                                    {{ $invoiceDetail->hsItemDetail->name }} [{{ $invoiceDetail->hsItemDetail->code }}]
                                </td>

                                <td style="text-align: right;">
                                    {{ number_format($invoiceDetail->quantity, 2) }}
                                </td>

                                <td style="text-align: right;">
                                    RP. {{ number_format($invoiceDetail->price, 2) }}
                                </td>

                                <td style="text-align: right;">
                                    RP. {{ number_format($invoiceDetail->sub_total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                Sub-Total :
                            </td>

                            <td style="text-align: right; font-weight: bold;">
                                RP. {{ number_format($ivObj->sub_total, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                @php $i++ @endphp
            @endforeach

            <!-- this applied when more then one invoice -->
            @if ($i > 1)
                <table class="table-bordered table w-100">
                    <tr>
                        <td colspan="4" class="text-center bg-success text-white">
                            Sub-Total keseluruhan Penjualan :
                        </td>

                        <td style="text-align: right; font-weight: bold; color: green;">
                            RP. {{ number_format($subTotalIV, 2) }}
                        </td>
                    </tr>
                </table>
            @endif
        @endif

        <table align="right">
                <tr>
                    <br><br><br><br><br><br><br><br>
                    <td><h5 style="text-align: center;">______________________</h5></td>
                </tr>

                <tr>
                    <td><h5 style="text-align: center;">(Harmony)<br>Manager</h5></td>
                </tr>
            </table>
    </div>

        <script type="text/php">
            if ( isset($pdf) ) {
                $font = $fontMetrics->getFont("helvetica", "bold");
                $pdf->page_text(750, 570, "Halaman: {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0,0,0));
            }
        </script>
    </body>
</html>