@extends('layouts.app')

@section('title')
    Vos classes
@stop

@section('breadcrumb')
    <li><strong>Affichage de votre(vos) classe(s)</strong></li>
@stop

@section('h1')
    Affichage des classes
@stop

@section('content')
<div class="container-fluid global-page">
    <div class="row">
        <div class="col-sm-12">
            @foreach($fichiers as $fichier)
                <?php
                if($fichier->niveau == 1)
                    $niveau = "CP";

                if($fichier->niveau == 2)
                    $niveau = "CE1";

                if($fichier->niveau == 3)
                    $niveau = "CE2";

                if($fichier->niveau == 4)
                    $niveau = "CM1";

                if($fichier->niveau == 5)
                    $niveau = "CM2";
                ?>
                <h3>Classe des {{ $niveau }}</h3>
                <p>Ecole  : <span class="colored-blue">{{ $fichier->ecole }}</span></p>
                <p>Identifiant des élèves :
                    <a target='_blank' href='/projets/dweb02/laravel/monpetitcartable/public/passwords/{{ $fichier->filepass}}' class="btn btn-form">Récuperer les identifiants de votre classe de {{ $niveau }}</a>
                    <a onclick="return confirm('Voulez-vous vraiment supprimer la classe de {{ $niveau }} ?');" href="/projets/dweb02/laravel/monpetitcartable/public/classe/delete-classe/{{ $fichier->id }}" class="btn btn-primary pull-right">Supprimer votre classe de {{ $niveau }}</a>
                </p>
            @endforeach
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Classe</th>
                        <th>Avatar</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Pseudo</th>
                        <th>Cartes</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($classes as $classe)
                        <?php
                        if($classe->niveau == 1)
                            $niveau = "CP";

                        if($classe->niveau == 2)
                            $niveau = "CE1";

                        if($classe->niveau == 3)
                            $niveau = "CE2";

                        if($classe->niveau == 4)
                            $niveau = "CM1";

                        if($classe->niveau == 5)
                            $niveau = "CM2";
                        ?>
                        <tr>
                            <td>{{ $niveau }}</td>
                            <td><img src='../../public/img/avatars/{{ $classe->avatar }}.png'></td>
                            <td>{{ $classe->nom }}</td>
                            <td>{{ $classe->prenom }}</td>
                            <td>{{ $classe->pseudo }} </td>
                            <td>{{ $classe->vie }} <img class="vies" src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" /></td>
                            <td><i class="fa fa-trash" aria-hidden="true"></i>
                                <a onclick="return confirm('Voulez-vous retirer {{ $classe->pseudo }} de la classe ?');" href="/projets/dweb02/laravel/monpetitcartable/public/classe/delete/{{ $classe->id }}">Retirer de la classe</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
