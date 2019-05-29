<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Movie;
use Auth;

class MovieController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $movies = Movie::paginate(25);
      return view('movies.index')->withMovies($movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
        'image' => 'required'
      ]);

      if($request->hasFile('image'))
      {
          $path = $request->file('image')->store('public/images');
          $path = explode('public/', $path);
          $path = $path[1];
      }

      $user = Auth::user();

      $movie = $user->movies()->create([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $path
      ]);

      return redirect()->route('movies.show', $movie->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $movie = Movie::findOrFail($id);
      return view('movies.show')->withMovie($movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $movie = Movie::findOrFail($id);
      return view('movies.edit')->withMovie($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'title' => 'required',
        'description' => 'required',
      ]);

      $movie = Movie::findOrFail($id);
      
      if($request->hasFile('image'))
      {
          Storage::delete($movie->image);
          $path = $request->file('image')->store('public/images');
          $path = explode('public/', $path);
          $path = $path[1];
          
          $movie->image = $path;
      }

      $movie->title = $request->title;
      $movie->description = $request->description;
      $movie->save();

      return redirect()->route('movies.show', $movie->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Movie::destroy($id);
    }
}
