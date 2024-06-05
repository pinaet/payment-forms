<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>IOH CONNECT - Alumni Gathering Event</title>
    </head>
    <body>
        <p>Dear {{$alumnus['firstname'] . ' ' . $alumnus['lastname'] }},</p>

        <p>You have successfully signed up to the Harrow Alumni Gathering event that will be held on 16 January 2020 in Harrow School, London. </p>

        <p>Please arrive at the Main Reception, Bursary, 5 High Street, Harrow on the Hill, Middlesex, HA1 3HP, walk under the arch and follow the path to the Shepherd Churchill Room. </p>

        <p>Free parking is available. It is located on Garlands Lane HA1 3GF and is a 7-minute walk to the Main Reception. You may also find street parking close by on West Street or Church Hill.</p>

        <i>Click image below to view full Harrow School map </i><span style="font-size: 20px">☟</span><br>

        <a href="{{url('uploads/how-to-find-us-labelled.pdf')}}" target="_blank"><img src="{{url('images/ioh-event-map.png')}}"></a>

        <p>We look forward to meeting you there!</p>

        <img src="{{url('images/iohconnect-logo.png')}}">

        <p style="font-weight: bold">IOH CONNECT (International Old Harrovians CONNECT)</p>
    </body>
</html>
