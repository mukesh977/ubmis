@extends('layouts.layouts')
@section('title', 'Ultrabyte | Dashboard')
@section('content')
    <style>
        .todo-list{
            margin-top: 25px !important;
        }

        #targetSalesChart{
            position: relative;
            height: 500px;
        }
        #targetSalesChart:after{
            position: absolute;
            bottom: 0;
            left: 0;
            background: #fff;
            height: 10px;
            width: 60px;
            content: '';
        }
    </style>
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
        @include('message.flash-message')
    </section>

    <!-- Main content -->
    <section class="content">
        @include('dashboard.partials.field-visit-partials')
        @include('dashboard.partials.marketing-officer.sales-reports')
        @include('dashboard.partials.marketing-manager.total-sales-reports')
        @include('dashboard.partials.field-visit-targets')
    </section>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    @role(['marketingOfficer', 'marketingManager'])
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("targetSalesChart", {
                animationEnabled: true,
                title:{
                    text: "Sales Target & User Sales."
                },
                axisY: {
                    title: "Sales Targets",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"
                },
                axisY2: {
                    title: "Actual Sales",
                    titleFontColor: "#C0504E",
                    lineColor: "#C0504E",
                    labelFontColor: "#C0504E",
                    tickColor: "#C0504E"
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor:"pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    name: "Sales Targets",
                    legendText: "Targets",
                    showInLegend: true,
                    dataPoints:{!! json_encode($salesTargets, JSON_NUMERIC_CHECK) !!}
                },
                    {
                        type: "column",
                        name: "User Sales",
                        legendText: "Sales",
                        axisYType: "secondary",
                        showInLegend: true,
                        dataPoints:{!! json_encode($sales, JSON_NUMERIC_CHECK) !!}
                    }]
            });
            chart.render();

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    </script>
    @endrole
@endsection