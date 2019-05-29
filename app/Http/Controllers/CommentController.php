<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Comment;
use Auth;
use App\Events\NewComment;

class CommentController extends Controller
{
  public function index(Movie $movie)
  {
    return response()->json($movie->comments()->with('user')->latest()->get());
  }

  public function store(Request $request, Movie $movie)
  {
    $data = $_SERVER['PHP_SELF'];
    $data = explode('/', $data);
    $id = $data[4];
    $body = $data[5];

    $comment = new Comment();
    $comment->body = $body;
    $comment->user_id = Auth::id();
    $comment->movie_id = $id;
    $comment->save();

    $comment = Comment::with('movie')->find($comment->id);
    
    // $comment = $movie->comments()->create([
    //   'body' => $body,
    //   'user_id' => Auth::id(),
    //   'movie_id' => $id
    // ]);

    $comment = Comment::where('id', $comment->id)->with('user')->first();
    broadcast(new NewComment($comment))->toOthers();
    return $comment->toJson();
  }
}
