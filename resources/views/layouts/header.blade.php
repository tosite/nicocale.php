<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<meta name=description content="ニコカレ">
<meta name=format-detection content="telephone=no,address=no,email=no">
<meta property=og:type content=website>
<meta property=og:image content="{{ secure_asset('shortcut-icon.png') }}">
<meta name=twitter:card content=summary>
<meta name=twitter:site content=@mao_sum>
<meta property=og:url content=https://nicocale.app>
<meta property=og:title content="NicoCale">
<meta property=og:description content="ニコカレ">
<meta property=og:site_name content="NicoCale">
<meta property=og:locale content=ja_JP>

<title>{{ config('app.name', 'Laravel') }}</title>

<script src="{{ secure_asset('js/app.js') }}" defer></script>
<script>window.Laravel = {csrfToken: "{{ csrf_token() }}"};</script>

<link rel="icon" href="{{ secure_asset('favicon.ico') }}" type="image/vnd.microsoft.icon">
<link rel="shortcut icon" href="{{ secure_asset('shortcut-icon.png') }}" type="image/vnd.microsoft.icon">
<link rel=apple-touch-icon href="{{ secure_asset('shortcut-icon.png') }}" type="image/vnd.microsoft.icon">

<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
<link rel=canonical href="ニコカレ">

