@extends('layouts.app')

@section('breadcrumb')
    <li><strong>Profil de votre enfant</strong></li>
@endsection

@section('title')
    Profil de votre enfant
@stop

@section('content')
<!--
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover{background-color:#f5f5f5}
</style>
-->
<div class="container-fluid global-page">
    <div class="row">
        @foreach($infos as $info)
            <div class="col-sm-8">
                <h1>Profil de {{ $info->pseudo }}</h1>
                <p>Nom : <span class="colored-blue">{{ $info->nom }}</span></p>
                <p>Prénom : <span class="colored-blue">{{ $info->prenom }}</span></p>
                <p>Vies : <span class="colored-blue">{{ $info->vie }}</span></p>
                <p>Inscrit le : <span class="colored-blue">{{ $info->date_inscription }}</span></p>
                @foreach($fichiers as $fichier)
                    <p>Mot de passe : <a target='_blank'      href='/projets/dweb02/laravel/monpetitcartable/public/passwords/{{ $fichier->filepass }}' class="btn btn-form">Récuperer les identifiants de votre enfant</a></p>
                @endforeach
            </div>
            <div class="col-sm-4">
                <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/avatars/{{ $info->avatar }}.png" />
            </div>
        @endforeach
    </div>
</div>
@endsection