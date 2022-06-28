<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!--A few headers to manage potential risks on public facing site-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains; preload">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv='X-XSS-Protection' content='1'>
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <meta name="X-Frame-Options" content="DENY">
    <title>Laravel</title>
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('vendor/tabulator/dist/css/tabulator_semanticui.min.css') }}" rel="stylesheet" type="text/css"/>
</head>
<!--Simple body to present resulting application of test-->
<body class="antialiased">

<header>
 <h1>Devprox Exam (Ryan)</h1>
   <nav>
    <a href="/">Home</a>
    <a href="/Devprox developer test 2.pdf">Requirements Check</a>
    <a href="/students">Test Attempt</a>
   </nav>
</header>
