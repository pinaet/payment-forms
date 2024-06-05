
<!DOCTYPE html>
<html lang="en">
<head>
	<title>School Fee - Payment</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('pages.partials.csrf')
    
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{url('images/icons/his-favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ url('css/app.css?'). config('app.version') }}">
<!--===============================================================================================-->
</head>
<body>
	<div class="container-contact100">

		<div class="wrap-contact100">
            <div id="app">

                @php
                    $imgPath['logo']   = url('images/his-logo-blue.png');
                    $imgPath['modal']  = url('images/invoice-contact-name.gif');

                    $url['order']      = config('ticket.' . config('ticket.mode') . '.gate.order' );
                @endphp

                <school-fee
                    school-fee-raw     ="{{json_encode($school_fee)}}"
                    csrf-token         ="{{csrf_token()}}"
                    img-path-raw       ="{{json_encode($imgPath)}}"
                    url-raw            ="{{json_encode($url)}}">
                </school-fee>

            </div>
		</div>
    </div>


<!--===============================================================================================-->

    <script src="{{ url('js/school-fee-index.js?'). config('app.version') }}"></script>
    <script src="{{ url('js/validate-input.js?'). config('app.version') }}"></script>

<!--===============================================================================================-->
