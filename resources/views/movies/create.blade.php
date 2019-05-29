@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Novo filme</h1>
    <hr />
    <form method="post" action="{{ route('movies.store') }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="movie_title">Título</label>
        <input type="text" class="form-control" id="movie_title" name="title" placeholder="Título" value="{{ old('title') }}">
      </div>

      <div class="form-group">
        <label for="movie_image">Imagem</label>
        <input type="file" class="form-control" id="movie_image" name="image">
      </div>
      
      <div class="form-group">
        <label for="movie_content">Descrição</label>
        <textarea class="form-control" rows="8" id="movie_content" name="description" placeholder="Descrição..." value="{{ old('description') }}"></textarea>
      </div>

      <button type="submit" class="btn btn-primary btn-lg">Salvar filme</button>
    </form>

  </div>
@endsection
