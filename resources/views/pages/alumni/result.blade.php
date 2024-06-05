
<!DOCTYPE html>
<html lang="en">
<head>
	<title>IOH Connect - Thank You</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{url('images/icons/his-favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css?'). config('app.version') }}">
<!--===============================================================================================-->
</head>
<body>
	<div class="container-contact100" style="align-items: initial; background-color: #031643;">
        <div class="wrap-contact100" style="
        background-image:    url({{url('images/alumni_banner_03.jpg?'). config('app.version')}});
        background-size:     contain;                      /* <------ */
        background-repeat:   no-repeat;
        background-position: center center;
        display: table-cell;
        padding: 20px; height: 458px;
        vertical-align: top;
        border-style: none;
        background-color: #031643;
        ">
        </div>

		<div class="wrap-contact100">
            <div id="app">
                
                <alumni-form-result
                    alumnus-raw     ="{{json_encode($alumnus)}}"
                    csrf-token      ="{{csrf_token()}}">
                </alumni-form-result>

            </div>
		</div>
    </div>
    

<!--===============================================================================================-->

    <script src="{{ url('js/alumni-form-result.js?'). config('app.version') }}"></script>
    
<!--===============================================================================================-->