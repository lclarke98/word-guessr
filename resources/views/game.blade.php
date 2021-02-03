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

        #incorrect-guesses-container{
            float: right;
            padding: 10px;
            margin: 10px;
            border: 1px black solid;
        }

        #make-guess-container{
            float: left;
            padding: 10px;
            margin: 10px;
            border: 1px black solid;
            position: center;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #word-container{
            padding: 10px;
            margin: 10px;
            font-size: 20px;
        }

        .letter{
            display: inline;
        }

        #show-letter{
            color: black;
        }

        #hide-letter{
            color: white;
        }

        li{
            font-size: 40px;
        }

    </style>
</head>
<body>
<nav>
    <h1>Hi {{$name}} guess the word</h1>
    <h1>Number of guesses made {{$numGuess}} /11</h1>
    <h1>You word has {{$wordLength}} letters</h1>
</nav>

<div id="word-container">
    <ol>
        @foreach($wordArr as $row)
            @if ($row['display'] == 1)
                <li id="show-letter" class="letter">{{$row['letter']}}</li>
            @else
                <li id="show-letter" class="letter">_</li>
            @endif
        @endforeach
    </ol>
</div>

<form action="/game/guess" method="post" id="make-guess-container">
    @csrf
    <input name="word" type="hidden" value={{$word}}>
    <input name="numGuess" type="hidden" value={{$numGuess}}>
    <input name="guess" type="text" placeholder="Enter guess here" pattern="[a-z]{1}" required>
    <button>Make Guess</button>
</form>




<div id="incorrect-guesses-container">
    <h1>Incorrect Guesses</h1>
    @forelse ($incorrectGuessList as $ig)
        <li>{{ $ig->guess }}</li>
    @empty
        <p>No incorrect guesses made yet</p>
    @endforelse
</div>





</body>
</html>
