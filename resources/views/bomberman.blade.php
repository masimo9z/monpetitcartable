@extends('layouts.app')

@section('breadcrumb')
    <li><strong>Bomberman</strong></li>
@stop

@section('title')
    Bomberman
@stop

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page padding-bottom">
    <div class="games">
        <div class="row">
            <h1>Bomberman</h1>
            <div class="col-sm-12">
                <div class="game-img">
                    <p>Vous avez <strong>1</strong> partie. Bonne chance !</p>
                    
                    <?php include("../public/jeux/bomberman/client/index.php"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
