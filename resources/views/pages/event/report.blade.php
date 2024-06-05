<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Report - {{$event->name}}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    @include('pages.partials.csrf')

    <style>
        ul#menu li {
            display:inline;
        }
        .expedition-header {
            text-align: center;
            height: 60px;
            border-bottom: none;
            padding-bottom: 0px;
            margin-bottom: -5px;
            margin-top: 20px;
        }
        .expedition-header.sub {
            text-transform: none;
            margin-top: 20px;
        }
        .expedition-admin-main-menu {
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .dropdown-menu>a:active {
            background: #a39163;
        }
        .hd-search{
            padding: 4px !important;
            width: 100%;
            /* border: none !important; */
        }
        .hd-search>input{
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            border: none !important;
            text-align: center;
        }
        .contain-table-div{
            width: 100%;
            overflow: auto;
            border: 1px solid #a39163;
            border-radius: 5px;
            padding: 5px;
        }
        .row-toolbar{
            background-color: #efefef;
            margin: 1px;
            border-radius: 5px;
            padding-top: 15px;
            padding-bottom: 0px;
        }
        #table-buttons{
            padding-top: 8px;
            margin: 0px;
            padding-left: 20px;
        }
    </style>
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{url('images/icons/his-favicon.ico')}}"/>
<!--===============================================================================================-->
    <script src="{{ url('js/datatable-event.js?'). config('app.version') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ url('css/plain-report.css?'). config('app.version') }}">
<!--===============================================================================================-->
</head>
<body>
    <div id="wrap" style="padding: 25px;">

        <div id="app">

            <div>

                <div class="row" style="display: block">
                    <h1 class="page-header expedition-header sub text-center"><i class="fas fa-users"></i> {{$event->name}} Event Report</h1>
                </div>
                <div class="row row-toolbar">
                    <div id="table-buttons" class="col-6"></div>
                    <div class="col-6">
                        <div class="form-group row" data-column="99">
                            <label for="col99_filter" class="col-sm-2 col-form-label">Filter :</label>
                            <div class="col-sm-10" >
                                <input type="text" class="column_filter form-control input-md" id="col99_filter" placeholder="Type to filter data">
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- <div id="table-buttons"></div> --}}
                <div class="row">
                        
                    <event-report
                        event-raw           ="{{json_encode($event)}}"
                        event-report-raw    ="{{json_encode($event_report)}}"
                        event-user-raw      ="{{json_encode($event_user)}}"
                        report-raw          ="{{json_encode($report)}}"
                        csrf-token          ="{{csrf_token()}}">
                    </event-report>

                    <p>&nbsp;</p>
                </div>

            </div>
        </div>

    </div>
    <!-- /#wrapper -->

    <script src="{{ url('js/event-report.js?'). config('app.version') }}"></script>
</body>

</html>