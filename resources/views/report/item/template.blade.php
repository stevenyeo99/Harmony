<!DOCTYPE html>
<html>
    <head>
        <title>Transaction Item Report</title>
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
                <div style="border: 2px solid #337ab7;">
                    <h1 class="text-center text-primary pr-1" 
                    style="text-decoration: underline;">
                        <img src="./img/kasir.png" style="width: 50px;">Harmony-Market
                    </h1>

                    <p>
                        Laporan Transaksi Item
                        <br>
                        Periode: {{ \Carbon\Carbon::parse($date_from)->format('m/d/yy') }} s/d {{ \Carbon\Carbon::parse($date_to)->format('m/d/yy') }}
                    </p>
                </div>

                <hr>
            </center>

            @if (!$dataExist) 
                <table class="table-bordered table w-100">
                    <tr>
                        <td rowspan="2" class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Waktu Proses
                        </td>

                        <td colspan="3" class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Kuantiti
                        </td>

                        <td rowspan="2" class="text-center align-middle bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Tipe Proses
                        </td>

                        <td rowspan="2" class="text-center align-middle bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                            Deskripsi
                        </td>
                    </tr>

                    <tr>
                        <td class="text-center bg-primary text-white" style="font-weight: bold;">Sebelum</td>
                        <td class="text-center bg-primary text-white" style="font-weight: bold;">+/-</td>
                        <td class="text-center bg-primary text-white" style="font-weight: bold;">Sesudah</td>
                    </tr>
                    
                    <tr>
                        <td style="text-align: center;" colspan="6">Tidak terdapat data pada periode ini.</td>
                    </tr>
                </table>
            @else
                @php $i = 1 @endphp
                @foreach ($listOfHsItemDetail as $itemObj)
                    <table class="table-bordered table w-100" style="@if($i > 1) page-break-before: always; @endif">
                        <tbody>
                            <tr>
                                <td colspan="6" class="bg-primary text-white" style="font-weight: bold; text-decoration: underline;">
                                    {{ $itemObj->name }} - [{{ $itemObj->code }}]
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="2" class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                    Waktu Proses
                                </td>

                                <td colspan="3" class="text-center bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                    Kuantiti
                                </td>

                                <td rowspan="2" class="text-center align-middle bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                    Tipe Proses
                                </td>

                                <td rowspan="2" class="text-center align-middle bg-primary text-white" style="vertical-align: middle; font-weight: bold;">
                                    Deskripsi
                                </td>
                            </tr>

                            <tr>
                                <td class="text-center bg-primary text-white" style="font-weight: bold;">Sebelum</td>
                                <td class="text-center bg-primary text-white" style="font-weight: bold;">+/-</td>
                                <td class="text-center bg-primary text-white" style="font-weight: bold;">Sesudah</td>
                            </tr>
                            
                            @if (count($itemObj->listOfItemStockLogs) > 0)
                                @foreach ($itemObj->listOfItemStockLogs as $itemStockLog)
                                    <tr>
                                        <td style="text-align: center; width: 20%;">
                                            {{ \Carbon\Carbon::parse($itemStockLog->change_time)->format('m/d/y h:i:s') }}
                                        </td>

                                        <td style="text-align: right; width: 10%;">
                                            {{ number_format($itemStockLog->original_quantity, 2) }}
                                        </td>

                                        <td style="text-align: right; width: 10%;">
                                            @if ($itemStockLog->plusOrMinusQuantity == 'PLUS')
                                                <span style="color: green;">+{{ number_format($itemStockLog->add_quantity, 2) }}</span>
                                            @else 
                                                <span style="color: red;">-{{ number_format($itemStockLog->min_quantity, 2) }}</span>
                                            @endif
                                        </td>

                                        <td style="text-align: right; width: 10%;">
                                            {{ number_format($itemStockLog->new_quantity, 2) }}
                                        </td>

                                        <td style="width: 15%">
                                            {{ $itemStockLog->change_type }}
                                        </td>

                                        <td>
                                            {{ $itemStockLog->DESCRIPTION }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="text-align: center" colspan="6">Tidak terdapat data pada periode ini.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    @php $i++ @endphp
                @endforeach
            @endif
            
            <div style="position: absolute; bottom: 10; margin-right: 30px;">
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