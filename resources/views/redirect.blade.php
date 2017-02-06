@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row boutique">
        <div class="col-sm-12">
            <h2>Redirection</h2>
            <p>{{ $message }}</p>
            <?php header("refresh:1;url=https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public".$lienredirect); ?>
        </div>
    </div>
</div>

@endsection
