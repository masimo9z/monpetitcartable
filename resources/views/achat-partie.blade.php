@extends('layouts.app')

@section('breadcrumb')
    <li><strong>Bomberman - acheter une partie</strong></li>
@stop

@section('title')
    Bomberman
@stop

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page padding-bottom">
    <div class="games">
        <div class="row">
            <h1>Bomberman - Acheter une partie</h1>
            <div class="col-sm-12">
                <div class="game-img">
                    <p>Vous avez : <strong>{{ Auth::user()->vie }}</strong> <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" class="icon-vies"></p>
                    <p>Une partie sur le jeu Bomberman vous coûtera : <strong>10</strong> <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" class="icon-vies"></p>
                    
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/achat-partie') }}">
                        {{ csrf_field() }}
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <input type="submit" name="achat" class="btn btn-primary" value="Acheter"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
