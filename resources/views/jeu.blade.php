@extends('layouts.app')

@section('breadcrumb')
    <li id="breadcrumb-classe"><a href="">Classe</a></li>
    <li id="breadcrumb-matiere"><a href="">Matière</a></li>
    <li><strong>Jeu</strong></li>
@stop

@section('title')
    Jeu
@stop

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page padding-bottom">
    <div class="games">
        <div class="row">
            @foreach($infos_jeu as $info)
                <h1>{{ $info->nom }}</h1>
            <div class="col-sm-12">
                @if($note === 0)
                    <p>Ce jeu n'a pas encore été évalué.</p>
                @else
                    @foreach($tanote as $yournote)
                        <p>Moyenne :
                            <span class="stars">
                                <?php
                                    for ($i = 1; $i <= $result; $i++) {
                                        echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                    }
                                    for ($i = 1; $i <= (5-$result); $i++) {
                                        echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                    }
                                ?>
                            </span>
                         <em>(votre note : {{ $yournote }})</em></p>
                    @endforeach
                @endif

                <div class="game-img">
                    <?php
                        include("../public/jeux/".$info->id."/index.php");
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <h2>Présentation du jeu</h2>
            <p class="col-sm-6">
                {{ $info->description }}
            </p>
            <div class="col-sm-6 miniatures">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="banner banner2">
    <div class="container-fluid">
        <div class="banner-select">
          <h3>Note le jeu</h3>
            <!--
            <form class="form-horizontal" role="form" method="POST" action="{{ Request::fullUrl() }}">
                {{ csrf_field() }}
                <select name="note" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i> Noter
                </button>
             </form>
-->
            <div class="row noter-jeu">
              <form class="form-horizontal" role="form" method="POST" action="{{ Request::fullUrl() }}">
                <div class="col-sm-12">
                    {{ csrf_field() }}
                  <div id="ranks" for="rank">
                    <input name="rank" type="hidden" value="0" id="rankInput">
                      <label for="1">
                    <input name="stars" type="checkbox" id="1" value="1" onclick="checkRank(1)"><i class="fa fa-star"></i>
                      </label>
                      <label for="2">
                    <input name="stars" type="checkbox" id="2" value="2" onclick="checkRank(2)"><i class="fa fa-star"></i>
                      </label>
                      <label for="3">
                    <input name="stars" type="checkbox" id="3" value="3" onclick="checkRank(3)"><i class="fa fa-star"></i>
                      </label>
                      <label for="4">
                    <input name="stars" type="checkbox" id="4" value="4" onclick="checkRank(4)"><i class="fa fa-star"></i>
                      </label>
                      <label for="5">
                    <input name="stars" type="checkbox" id="5" value="5" onclick="checkRank(5)"><i class="fa fa-star"></i>
                      </label>
                  </div>
                  <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary">
                      <i class="fa fa-btn fa-check"></i> Noter
                    </button>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid global-page padding-bottom">
    <h3>Commentaires</h3>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
            @if($comments != 0)
                @foreach($comments as $comment)
                    <tr>
                        <td><img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/avatars/{{ $comment->avatar }}.png"></td>
                        <td>{{ $comment->pseudo }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->timestamp }}</td>
                    </tr>
                @endforeach
            @else
                <p>Il n'y a pas encore de commentaire pour ce jeu.</p>
            @endif
            </table>
        </div>
    </div>

    <h3>Ajouter un commentaire</h3>
    <div class="row">
      <form class="form-horizontal col-sm-12 commentaires" role="form" method="POST" action="{{ Request::fullUrl() }}/comment">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
              <label for="comment">Votre commentaire : </label>
              <textarea id="comment" type="text" class="form-control" name="comment" value="{{ old('comment') }}"></textarea>
              @if ($errors->has('comment'))
              <span class="help-block">
                  <strong>{{ $errors->first('comment') }}</strong>
              </span>
              @endif
          </div>
          <button type="submit" class="btn btn-primary">
              <i class="fa fa-btn fa-commenting"></i> Commenter
          </button>
      </form>
    </div>

</div>
        @endforeach
@endsection
