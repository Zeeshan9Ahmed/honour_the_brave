
<head>
	<!-- META TAGS-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<!-- META TAGS-->
	<title>Honour the Brave</title>	
	<link rel="icon" href="{{asset('images/favicon.png')}}" />
	<!-- BOOTSTRAP 5 -->	
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
	<!-- BOOTSTRAP 5 -->
	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- GOOGLE FONTS -->
	<!-- FONT AWESOME -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"></li>
	<!-- FONT AWESOME -->
	<!-- STYLE SHEETS -->
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/notifIt.css')}}">

    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('additional_styles')
	<!-- STYLE SHEETS -->
</head>

