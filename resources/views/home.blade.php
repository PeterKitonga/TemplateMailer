@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col m4 s12">
            <div class="card-panel valign-wrapper">
                <p class="red-text flow-text left-align">{{ $countLogs }}</p>
                <div class="custom-vertical-divider center-align"></div>
                <span class="text-darken-2 right-align">Mails Sent</span>
            </div>
        </div>
        <div class="col m4 s12">
            <div class="card-panel valign-wrapper">
                <p class="red-text flow-text left-align">{{ $countTemplates }}</p>
                <div class="custom-vertical-divider center-align"></div>
                <span class="text-darken-2 right-align">No of Templates</span>
            </div>
        </div>
        <div class="col m4 s12">
            <div class="card-panel valign-wrapper">
                <p class="red-text flow-text left-align">{{ $countRecipients }}</p>
                <div class="custom-vertical-divider center-align"></div>
                <span class="text-darken-2 right-align">No of Recipients</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col m12">
            <div id="container" style="min-width: 310px; height: auto; margin: 0 auto"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        $(function () {
            var $data = $.parseJSON('{!! $graphData !!}');

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Mail Transactions'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: $data.months,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Successful Mail',
                    data: $data.successful,
                    color:'#38546d'

                }, {
                    name: 'Failed Mail',
                    data: $data.failed,
                    color:'#F44336'

                }]
            });
        });
    </script>
@endpush
