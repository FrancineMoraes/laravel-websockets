@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Novo filme</h1>
    <hr />
    <form method="post" action="{{ route('movies.update', $movie->id) }}" id="update-movie" enctype="multipart/form-data">
      {{ method_field('put') }}
      {{ csrf_field() }}
      <div class="form-group">
        <label for="movie_title">Título</label>
        <input type="text" class="form-control" id="movie_title" placeholder="Title" value="{{ $movie->title }}" name="title">
      </div>

      <div class="form-group">
        @if($movie->image)
            <label for="movie_image">Imagem inserida</label>
            <br>
            <img src="{{asset('storage/'.$movie->image)}}" width="150px;" height="150px;" src="" alt="">
            <br>
        @endif
        <label for="movie_image">Imagem</label>
        <input type="file" class="form-control" id="movie_image" name="image">
      </div>

      <div class="form-group">
        <label for="movie_content">Descrição</label>
        <textarea class="form-control" rows="8" id="movie_content" placeholder="Descrição..." name="description">{{ $movie->description }}</textarea>
      </div>

    </form>

    <button onclick="event.preventDefault();
             document.getElementById('update-movie').submit();" class="btn btn-success btn-lg">Salvar filme</button>

    <button onclick="event.preventDefault();
             document.getElementById('delete-movie-form').submit();" class="btn btn-lg btn-danger"><i class="fa fa-trash"></i></button>
    <form id="delete-movie-form" method="post" action="{{ route('movies.destroy', $movie->id) }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}
    </form>

  </div>
@endsection
