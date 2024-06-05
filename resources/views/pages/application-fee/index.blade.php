
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Application Fee - Payment</title>
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
                    $imgPath['loading']= url('images/payment_data_loading.gif');

                    // $url['order']      = config('ticket.' . config('ticket.mode') . '.gate.order' ); //prod
                    $url['order']      = config('ticket.ticket.gate.order' ); //uat
                    $url['base']       = url('/');
                @endphp

                <application-fee
                    application-fee-raw="{{json_encode($application_fee)}}"
                    csrf-token         ="{{csrf_token()}}"
                    img-path-raw       ="{{json_encode($imgPath)}}"
                    url-raw            ="{{json_encode($url)}}"
                    data-raw           ="{{json_encode($data)}}">
                </application-fee>

            </div>
		</div>
    </div>


<!--===============================================================================================-->

    <script src="{{ url('js/application-fee-index.js?'). config('app.version') }}"></script>

<!--===============================================================================================-->
