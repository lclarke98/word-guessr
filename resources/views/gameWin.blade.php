<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        h1{
            text-align: center;
        }

        #container{
            margin-top: 45vh;
        }

        button{
            text-align: center;
        }

    </style>
</head>
<body>

<div id="container">
    <h1>Congratulations {{$name}} you win.</h1>
    <h1>Your word was: {{$word}}.</h1>

    <a href="{{ url('/') }}" class="btn btn-xs btn-info pull-right"><button>Play Again</button></a>
</div>







</body>
</html>
