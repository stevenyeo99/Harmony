@extends('layouts.master')

@section('content')
<!-- start card display -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                {{ $title1 }}
            </div>

            <div class="card-body">
                <!-- <div class="form-inline mb-2">
                    <div class=" form-group col-sm-4 col-md-4 col-lg-4 pl-0">
                        {{ Form::text('name', old('name'), array('class' => 'form-control w-100', 'maxlength' => '50', 'readonly' => true)) }}
                    </div>

                    <div class="form-group col-sm-4 col-md-4 col-lg-4 pl-0">
                        {{ Form::text('code', null, array('class' => 'form-control w-100', 'maxlength' => '20', 'readonly' => true)) }}
                    </div>

                    <input type="button" value="Lihat" class="btn btn-primary">
                </div> -->

                <div class="panel-heading">
                    <b>Analisis Grafik Penjualan 7 Hari Terakhir</b>
                </div>

                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end display card -->
@endsection

@push('scripts')
    <script type="text/javascript">
        var url = "{{ route('line_chart_json') }}";
        var days = new Array();
        var months = new Array();
        var years = new Array();
        var prices = new Array();

        $(document).ready(function() {
            retrieveJsonData(url);
        });

        function retrieveJsonData(routeUrl) {
            $.get(routeUrl, function(response) {
                response.forEach(function (data) {
                    days.push(data.invoice_datetime);
                    prices.push(data.sub_total);
                });

                var ctx = document.getElementById("canvas").getContext("2d");

                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: days,
                        datasets: [{
                            label: 'Total Penghasilan',
                            data: prices,
                            // fill: false,
                            borderColor: "#03fc31",
                            // borderDash: [5, 5],
                            backgroundColor: "#4dfcff",
                            pointBackgroundColor: "#FF0000",
                            pointBorderColor: "#55bae7",
                            pointHoverBackgroundColor: "#FF0000",
                            pointHoverBorderColor: "#00FF00",
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return 'RP. ' + getPriceFormattedNumber(value, 2);
                                    }
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return 'Total Penghasilan : RP. ' + getPriceFormattedNumber(tooltipItem.yLabel, 2);
                                }
                            }
                        }
                    }
                });
            });
        }
    </script>
@endpush
