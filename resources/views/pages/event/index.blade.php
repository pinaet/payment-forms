
<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $event['name'] }} - Payment</title>
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
                    $url['root']       = url('/');
                @endphp

                <event-order
                    event-raw          ="{{json_encode($event)}}"
                    event-order-raw    ="{{json_encode($eventOrder)}}"
                    tickets-raw        ="{{json_encode($tickets)}}"
                    csrf-token         ="{{csrf_token()}}"
                    img-path-raw       ="{{json_encode($imgPath)}}"
                    url-raw            ="{{json_encode($url)}}">
                </event-order>

            </div>
		</div>
    </div>


<!--===============================================================================================-->

    <script src="{{ url('js/event-order-index.js?'). config('app.version') }}"></script>
    <script src="{{ url('js/validate-input.js?'). config('app.version') }}"></script>

<!--===============================================================================================-->
