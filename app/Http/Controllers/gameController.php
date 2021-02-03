<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;


class gameController extends Controller
{
    //function creates a new game
    public function createGame(Request $request)
    {
        $name = request('playerName');
        $wordID = rand(0,500);

        $gameID = DB::table('user')->insertGetId([
            'player_name' => $name,
            'word_id' => $wordID
        ]);

        DB::table('game')
            ->insert([
                'game_id' => $gameID,
                'word' => $wordID,
                'num_guesses' => 0
            ]);

        $request->session()
            ->put('gameID', $gameID);

        return redirect('/game');
    }

    //function processes the players guess
    public function turn(Request $request)
    {
        $gameID = $request->session()->get('gameID');
        $numGuess = request('numGuess');
        $guess = request('guess');

        $word = request('word');

        if ($numGuess >= 11) {
            return redirect('/gameOver');
        }

        if (Str::contains($word, $guess)) {
            DB::table('guess')
                ->insert([
                    'game_id' => $gameID,
                    'guess' => $guess,
                    'correct' => 1
                ]);
        } else {
            DB::table('guess')
                ->insert([
                    'game_id' => $gameID,
                    'guess' => $guess,
                    'correct' => 0
                ]);
        }

        DB::table('game')
            ->where('game_id', $gameID)
            ->update(['num_guesses' => $numGuess + 1]);

        return redirect()->back();
    }

    //function loads the game page
    public function game(Request $request)
    {
        $gameID = $request->session()->get('gameID');

        $incorrectGuessList = DB::table('guess')
            ->whereRaw('game_id = ? AND correct = 0', [$gameID])
            ->get();

        $correctGuessList = DB::table('guess')
            ->whereRaw('game_id = ? AND correct = 1', [$gameID])
            ->get() ->toArray();

        $user = DB::table('user')
            ->where('id', $gameID)
            ->first();

        $numGuess = DB::table('game')
            ->where('game_id', $gameID)
            ->first();

        $word = $this->getWord($user-> word_id);

        if (strlen($word) == count($correctGuessList)) {
            return redirect('/gameWin');
        }


        return view('game', [
            'name' => $user -> player_name,
            'gameId' => $gameID,
            'incorrectGuessList' => $incorrectGuessList,
            'correctGuessList' => $correctGuessList,
            'word' => $word,
            'wordArr' => $this->displayWord(str_split($word), $correctGuessList),
            'wordLength' => strlen($word),
            "numGuess" => $numGuess ->num_guesses
        ]);
    }

    //function gets the word from the database
    public  function getWord($wordID)
    {
        $query = DB::table('words')
            ->select('word')
            ->where('id', $wordID)
            ->first();

        return $query -> word;
    }

    //function creates the display word for the game page
    public function displayWord($wordArr, $guessList)
    {
        $displayWord = collect();
        $guessCollection = collect();

        foreach ($guessList as $guess) {
            $guessCollection ->push($guess->guess);
        }

        foreach ($wordArr as $letter) {
            $letters = [
                'letter' => $letter,
                'display' => in_array($letter, $guessCollection->toArray())
            ];

            $displayWord -> push($letters);
        }

        return $displayWord;
    }

    //function loads the game over page
    public function gameOver(Request $request)
    {
        $gameID = $request->session()->get('gameID');

        $user = DB::table('user')
            ->where('id', $gameID)
            ->first();

        $game = DB::table('game')
            ->where('game_id', $gameID)
            ->first();

        $word = $this -> getWord($game->word);

        return view('gameOver', [
            'name' => $user -> player_name,
            'word' => $word,
        ]);
    }

    //new comment
    //new comment
    //new comment
    //new comment
    //new comment
    //new comment
    //new comment
    //new comment
    //new comment
    //new comment


    //function loads the game won page.
    public function gameWin(Request $request)
    {
        $gameID = $request->session()->get('gameID');

        $user = DB::table('user')
            ->where('id', $gameID)
            ->first();

        $game = DB::table('game')
            ->where('game_id', $gameID)
            ->first();

        $word = $this -> getWord($game->word);

        return view('gameWin', [
            'name' => $user -> player_name,
            'word' => $word,
        ]);
    }



}



