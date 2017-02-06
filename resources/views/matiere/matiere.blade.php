@extends('layouts.app')

@section('id-page'){{'matiere'}}@endsection
@section('class-page'){{'matiere'}}@endsection

@section('title')
        {{ $objectNiveaux[rankObjectClasse()]['Name'] }} - {{ $objectMatieres[rankObjectMatiere()]['Name'] }}
@endsection

@section('h1')
    Tous les jeux de {{ $objectMatieres[rankObjectMatiere()]['name'] }} de {{ $objectNiveaux[rankObjectClasse()]['Name'] }}
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/programme/'.$classe) }}">{{ $objectNiveaux[rankObjectClasse()]['Name'] }}</a></li>
    <li><strong>{{ $objectMatieres[rankObjectMatiere()]['Name'] }}</strong></li>
@endsection

@section('content')
<div class="container-fluid global-page">
    <div class="menumatieres col-md-3 col-sm-3 col-xs-12">
        <h2>Toutes les matières</h2>
        
        @foreach ($objectMatieres as $objectMatiere)
            <div class="col-md-12 col-sm-12 col-xs-4">
                <a href="{{ url('/programme/'.$classe.'/'.$objectMatiere['href']) }}" type="button" class="btn btn-primary">{{ $objectMatiere['Name'] }}</a>
            </div>
        @endforeach
    </div>
    <div class="container-fluid">        
        <div class="games-selection col-md-9 col-sm-9 col-xs-12">
            <h1>Tous les jeux de {{ $objectMatieres[rankObjectMatiere()]['name'] }} de {{ $objectNiveaux[rankObjectClasse()]['Name'] }}</h1>
              
            @foreach($games as $game)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="card">
                    <h4 class="card-title">{{ $game->nom }}</h4>
                    <img class="card-img-top" src="../../img/jeux/{{ $game->id }}.png" alt="Card image cap">
                    <div class="card-block">
                        <p class="card-text">{{ $game->description }}</p>
                        <a href="{{ url('programme/'.$classe.'/'.$matiere.'/'.$game->id)}}" class="btn btn-primary">Jouer</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
    <div class="banner banner2">
      <div class="container-fluid">
        <div class="banner-select">
          <h3>Nos autres niveaux</h3>
            @foreach ($objectNiveaux as $objectNiveau)
                @if ($objectNiveau['name'] != $classe)
                    <a href="{{ url('/programme/'.$objectNiveau['name']) }}" type="button" class="btn btn-info">{{ $objectNiveau['Name'] }}</a>
                @endif
            @endforeach
        </div>
      </div>
    </div>
@endsection