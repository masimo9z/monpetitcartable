@extends('layouts.app')

@section('id-page')
homepage
@stop
@section('class-page')
homepage
@stop

@section('title')
    Mon Petit Cartable
@stop

@section('content')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="img/slider-accueil/children-1.jpg" alt="Fille jouant à Mon petit cartable">
            <div class="carousel-caption">
              <h2>Apprends en t'amusant</h2>
              <p>Sélectionne ta classe et ta matière</p>
            </div>
          </div>
          <div class="item">
            <img src="img/slider-accueil/children-2.jpg" alt="Élèves jouant à Mon petit cartable">
            <div class="carousel-caption">
              <h2>Gagne des vies à chaque jeu</h2>
              <p>Puis dépense-les dans la boutique ou en jouant à Bomberman</p>
            </div>
          </div>
            <div class="item">
            <img src="img/slider-accueil/children-3.jpg" alt="Garçons jouant à Mon petit cartable">
            <div class="carousel-caption">
              <h2>Joue contre tes amis</h2>
              <p>Découvre notre jeu phare : Bomberman !</p>
            </div>
          </div>
        </div>
                
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span aria-hidden="true"><img src="img/icons/fleche-gauche.svg"></span>
          <span class="sr-only">Précédent</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span aria-hidden="true"><img src="img/icons/fleche-droite.svg"></span>
          <span class="sr-only">Suivant</span>
        </a>
      </div>

      <div class="banner">
        <div class="container-fluid">
          <div class="banner-select">
            <h3>Tu es</h3>
            <a href="{{ url('/vous-etes-professeur') }}" class="btn btn-secondary">Professeur</a>
            <a href="{{ url('/vous-etes-parent') }}" class="btn btn-secondary">Parent</a>
            <a href="{{ url('/vous-etes-eleve') }}" class="btn btn-secondary">Élève</a>
          </div>
          </div>
        </div>

        <div class="container-fluid games-selection">
          <h2>Sélection de jeux</h2>
            
        @foreach($meilleurs_jeux as $jeu)
          <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <div class="card">
              <h4 class="card-title">{{ $jeu->nom }}</h4>
                <span class="categorie">{{ $jeu->matiere }}</span> -
                <span class="classe">CE2</span>
                <div class="notes">
                    <?php 
                        for ($i = 1; $i <= $jeu->moyenne; $i++) {
                            echo '<i class="fa fa-star" aria-hidden="true"></i>';
                        }
                        for ($i = 1; $i <= (5-$jeu->moyenne); $i++) {
                            echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
                        }
                    ?>
                </div>
              <img class="card-img-top" src="img/jeux/{{ $jeu->id_jeu }}.png" alt="Card image cap">
              <div class="card-block">
                <p class="card-text">{{ $jeu->description }}</p>
                <a href="programme/ce2/{{ $jeu->matiere }}/{{ $jeu->id_jeu }}" class="btn btn-primary">Jouer</a>
              </div>
            </div>
          </div>
        @endforeach
        </div>

        <div class="banner banner2">
          <div class="container-fluid">
            <div class="banner-select">
                @if (Auth::guest())
                  <h3>Commences à jouer</h3>
                  <a href="#connexion" type="button" class="btn btn-info">Connexion</a>
                  <a href="#inscription" type="button" class="btn btn-info">Inscription</a> 
                @else
                    @if (Auth::user()->groupe == '1')
                        <h3>Accède à ton compte</h3>
                        <li type="button" class="btn btn-info"><a href="{{url('/compte')}}">Mon compte</a></li>
                      @elseif (Auth::user()->groupe == '2' || Auth::user()->groupe == '3')
                        <h3>Accèdez à votre compte</h3>
                        <li type="button" class="btn btn-info"><a href="{{url('/compte')}}">Votre compte</a></li>
                      @endif
                @endif
            </div>
          </div>
        </div>

        <div class="container-fluid concept">
          <h2>Le concept</h2>
          <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <div class="concept-top">
              <span class="concept-icon">
                <img src="img/icons/books.png" />
              </span>
              <h3>Sélectionne un exercice</h3>
            </div>
            <p>
              Mon petit cartable te propose plusieurs exercices sous forme de jeux. Tu vas pouvoir améliorer ton niveau en français, mathématique et géographie tout en t’amusant un maximum. 
            </p>
          </div>
          <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <div class="concept-top">
              <span class="concept-icon">
                <img src="img/icons/board.png" />
              </span>
              <h3>Collectionne des vies</h3>
            </div>
            <p>
              Impressionne tes camarades en récoltant un maximum de vies. Elles te permettront d’accéder à un jeu unique pour défier tes camarades.
            </p>
          </div>
          <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
            <div class="concept-top">
              <span class="concept-icon">
                <img src="img/icons/dice.png" />
              </span>
              <h3>Un outil qui s’adapte</h3>
            </div>
            <p>
              Vous êtes enseignant ou parent, enregistrez vos enfants ou votre classe afin qu’il puisse progresser tout en s’amusant. Assurez-un suivi minutieux de leur progression.
            </p>
          </div>
        </div>

@endsection