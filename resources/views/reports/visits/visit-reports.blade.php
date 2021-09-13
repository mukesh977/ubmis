@extends('layouts.layouts')
@section('title', 'Field Visits | Reports')
<style>
    #visit-report-charts{
        position: relative;
        height: 500px;
    }
    #visit-report-charts:after{
        position: absolute;
        bottom: 0;
        left: 0;
        background: #fff;
        height: 10px;
        width: 60px;
        content: '';
    }

    #visit-status-report{
        position: relative;
        height: 500px;
    }
    #visit-status-report:after{
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
            <li class="{{route('daily-field-visits.index')}}">Field Visit Lists</li>
            <li class="active">Visit Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Field Visit Report</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="col-md-6">
                            <div class="box-body box-success">
                                <div id="visit-status-report">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-body box-primary">
                                <div id="visit-report-charts">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <script>
      $(function () {
          $("#visit-status-report").CanvasJSChart({
              title: {
                  text: "Project Status Reports",
                  fontSize: 16
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
      });

        window.onload = function () {
            $("#visit-report-charts").CanvasJSChart({
                title: {
                    text: "Visit Category Reports",
                    fontSize: 16
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
                        dataPoints: {!! json_encode($visitReports, JSON_NUMERIC_CHECK) !!},
                    }
                ]
            });
        }
    </script>

@endsection