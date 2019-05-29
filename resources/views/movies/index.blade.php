@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1>Todos os filmes</h1>
      </div>

      <div class="col-md-4">
        <a href="{{ route('movies.create') }}" class="btn btn-primary pull-right" style="margin-top:15px;">Novo filme</a>
      </div>
    </div>
    <hr />
    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Título</th>
          <th>Descrição</th>
          <th>Imagem</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($movies as $movie)
          <tr>
            <th>{{ $movie->id }}</th>
            <td>{{ $movie->title }}</td>
            <td>{{ $movie->description}}</td>
            <td><img src="{{asset('storage/'.$movie->image)}}" width="150px;" height="150px;" src="" alt=""></td>
            <td><a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-sm btn-default">Editar</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="text-center">
      {{ $movies->links() }}
    </div>

  </div>
@endsection
