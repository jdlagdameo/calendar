<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
    <title>Calendar</title>
</head>
<body>
    <div id="app">
        <Navbar></Navbar>
        <App></App>
    </div>

    <script>
         const BASE_URL = '{{ URL::to("/") }}';
    </script>
    
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>