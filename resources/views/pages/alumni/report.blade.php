<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alumni Gathering Event Report</title>
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
    </style>
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{url('images/icons/his-favicon.ico')}}"/>
<!--===============================================================================================-->
    <script src="{{ url('js/datatable.js?'). config('app.version') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ url('css/plain-report.css?'). config('app.version') }}">
<!--===============================================================================================-->
</head>
<body>
    <div id="wrap">


        <div>
            <div id="main" class="container clear-top">

                <div id="app">

                    <div class="row" style="display: block">
                        <h1 class="page-header expedition-header sub text-center"><i class="far fa-calendar-alt"></i> Alumni Gathering Event Registration Report</h1>
                        <div class="col-lg-12 ">
                            <form class="form-horizontal">
                                <fieldset>
                                    <div class="form-group row" data-column="99">
                                        <label for="col99_filter" class="col-sm-2 col-form-label">Filter :</label>
                                        <div class="col-sm-10" >
                                            <input type="text" class="column_filter form-control input-md" id="col99_filter" placeholder="Type to filter data">
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                            {{-- {!! $table !!} --}}
                            @php
                                $pahts['report_update'] = url('/alumni/report/update');
                            @endphp
                            
                            <alumni-event-report
                                alumni-raw          ="{{json_encode($alumni)}}"
                                event-statuses-raw  ="{{json_encode($eventStatuses)}}"
                                paths-raw           ="{{json_encode($pahts)}}"
                                csrf-token          ="{{csrf_token()}}">
                            </alumni-event-report>

                        <p>&nbsp;</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /#wrapper -->

    <script src="{{ url('js/alumni-report.js?'). config('app.version') }}"></script>
</body>

</html>