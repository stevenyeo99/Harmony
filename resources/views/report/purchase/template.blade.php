<!DOCTYPE html>
<html>
    <head>
        <title>Transaction Purchase Report</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <style>
            tbody {
                display: table-row-group;
            }
        </style>
    </head>
        
    <body>
        <div class="container">
            <center>
                <div style="border-top: 5px double #337ab7; border-bottom: 5px double #337ab7; border-left: 3px solid #337ab7; border-right: 3px solid #337ab7;">
                    <h1 class="text-center text-primary pr-1" 
                    style="text-decoration: underline;">
                        <img src="./img/kasir.png" style="width: 50px;">HARMONY MARKET
                    </h1>

                    <p>
                        Laporan Transaksi Pembelian
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
                    @foreach ($listOfHsPurchase as $poObj)
                    <table class="table-bordered table w-100">
                        <tbody>
                            <tr>
                                <td colspan="4" class="bg-primary text-white" style="font-weight: bold; text-decoration: underline;">
                                    {{ \Carbon\Carbon::parse($poObj->purchase_datetime)->format('yy/m/d') }} - ({{ $poObj->po_no }})
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

                            @foreach ($poObj->hsPurchaseDetail as $purchaseDetail)
                                <tr>
                                    <td>
                                        {{ $purchaseDetail->hsItemDetail->name }} [{{ $purchaseDetail->hsItemDetail->code }}]
                                    </td>

                                    <td style="text-align: right;">
                                        {{ number_format($purchaseDetail->quantity, 2) }}
                                    </td>

                                    <td style="text-align: right;">
                                        RP. {{ number_format($purchaseDetail->price, 2) }}
                                    </td>

                                    <td style="text-align: right;">
                                        RP. {{ number_format($purchaseDetail->sub_total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                    Sub-Total :
                                </td>

                                <td style="text-align: right; font-weight: bold;">
                                    RP. {{ number_format($poObj->sub_total, 2) }}
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
                                Sub-Total keseluruhan Pembelian :
                            </td>

                            <td style="text-align: right; font-weight: bold; color: green;">
                                RP. {{ number_format($subTotalPO, 2) }}
                            </td>
                        </tr>
                    </table>
                @endif 
            @endif
        
            <div style="position: absolute; height: 60px; bottom: 10; margin-right: 30px;">
                <h5 style="text-align: right;">______________________</h5>
                <h5 style="text-align: right; margin-right: 41px;">(Harmony)</h5>
                <h5 style="text-align: right; margin-right: 46px;">Manager</h5>
            </div>
        </div>

        <script type="text/php">
            if ( isset($pdf) ) {
                $font = $fontMetrics->getFont("helvetica", "bold");
                $pdf->page_text(750, 570, "Halaman: {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0,0,0));
            }
        </script>
    </body>
</html>