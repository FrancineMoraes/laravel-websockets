@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ $movie->title }}</h1>
    {{ $movie->updated_at->toFormattedDateString() }}
    <hr />
    <p class="lead">
      <img src="{{asset('storage/'.$movie->image)}}" width="400px;" height="300px;" alt="">
      <br>
      {{ $movie->description }}
    </p>
    <hr />

    <h3>Comentários:</h3>
    <div style="margin-bottom:50px;" v-if="user">
      <textarea class="form-control" rows="3" name="body" placeholder="Deixe um comentário" v-model="commentBox"></textarea>
      <button class="btn btn-success" style="margin-top:10px" @click.prevent="postComment">Salvar comentário</button>
    </div>
    <div v-else>
      <h4>Você precisa estar logado para deixar um comentário!</h4> <a href="/login">Logar agora&gt;&gt;</a>
    </div>


    <div class="media" style="margin-top:20px;" v-for="comment in comments">
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="http://placeimg.com/80/80" alt="...">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">@{{comment.user.name}} said...</h4>
        <p>
          @{{comment.body}}
        </p>
        <span style="color: #aaa;">on @{{comment.created_at}}</span>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
  <script>

    const app = new Vue({
      el: '#app',
      data: {
        comments: {},
        commentBox: '',
        movie: {!! $movie->toJson() !!},
        user: {!! Auth::check() ? Auth::user()->toJson() : 'null' !!}
      },
      mounted() {
        this.getComments();
        this.listen();
      },
      methods: {
        getComments() {
          axios.get('/api/movies/'+this.movie.id+'/comments')
                .then((response) => {
                  this.comments = response.data
                })
                .catch(function (error) {
                  console.log(error);
                });
        },
        postComment() {
          axios.post('/api/movies/'+this.movie.id+'/'+this.commentBox+'/comment', {
            api_token: this.user.api_token,
            body: this.commentBox
          })
          .then((response) => {
            this.comments.unshift(response.data);
            this.commentBox = '';
          })
          .catch((error) => {
            console.log(error);
          })
        },
        listen() {
          Echo.channel('movie.'+this.movie.id)
              .listen('NewComment', (comment) => {
                this.comments.unshift(comment);
              })
        }
      }
    })

  </script>
@endsection
