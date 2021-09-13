@extends('layouts.layouts')
@section('title', 'Sales | Reports')
<style>
    #piechartContainer{
        position: relative;
        height: 500px;
    }
    #piechartContainer:after{
        position: absolute;
        bottom: 0;
        left: 0;
        background: #fff;
        height: 10px;
        width: 60px;
        content: '';
    }
</style>
@section('content')
    <section class="content-header">
        <small class="md-txt">Welcome @if(Auth::user()->hasRole('admin') == '1')Administrator @else {{ Auth::user()->first_name.' '.Auth::user()->last_name }} @endif, <a href="https://www.google.com/maps/place/3720+Emerald+St,+Torrance,+CA+90503/@33.8403836,-118.3543828,17z/data=!4m18!1m15!4m14!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!1m6!1m2!1s0x80c2b4d407f58b11:0xdedca55964c89054!2s3720+Emerald+St,+Torrance,+CA+90503!2m2!1d-118.3520761!2d33.8403792!3m1!1s0x80c2b4d407f58b11:0xdedca55964c89054" target="_blank"><i class="fa fa-map-marker rad-txt-danger"></i> Nepal</a></small>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="{{route('sales.index')}}">Sales Lists</li>
            <li class="active">Sales Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="box-body box-success">
                    <div class="row">
                        <!-- AREA CHART -->
                        <div id="piechartContainer">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <script type="text/javascript" src="{{asset('js/jquery.canvasjs.min.js')}}"></script>
    <script>
        window.onload = function () {
            $("#piechartContainer").CanvasJSChart({
                title: {
                    text: "Sales Reports of {{ $user }}"
                },
                animationEnabled: true,
                legend: {
                    verticalAlign: "center",
                    horizontalAlign: "left",
                    fontSize: 20,
                    fontFamily: "Helvetica"
                },
                theme: "light2",
                data: [
                    {
                        type: "pie",
                        indexLabelFontFamily: "Garamond",
                        indexLabelFontSize: 20,
                        indexLabel: "{label} {y}",
                        startAngle: -20,
                        showInLegend: true,
                        toolTipContent: "{legendText} {y}",
                        dataPoints: {!! json_encode($reportsData, JSON_NUMERIC_CHECK) !!},
                    }
                ]
            });
        }
    </script>

@endsection