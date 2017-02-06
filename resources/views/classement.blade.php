@extends('layouts.app')

@section('id-page')
classement
@stop
@section('class-page')
classement
@stop

@section('title')
    Classement
@stop

@section('breadcrumb')
    <li><strong>Classement</strong></li>
@endsection

@section('content')
<div class="container-fluid global-page padding-bottom">
    <div class="row">
      <h2>Podium des 3 meilleurs élèves</h2>
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="podium">
            @foreach($bestusers as $bestuser)
              <div class="user-card user-card-{{ $initbest }}">
                <img src="img/avatars/{{ $bestuser->avatar }}.png"/>
                <span>{{ $bestuser->pseudo }}</span>
              </div>
                <?php $initbest++ ?>
            @endforeach
          <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/podium.svg" />
        </div>
      </div>
    </div>
    <div class="row">
      <h1>Classement des élèves</h1>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Position</th>
                        <th>Avatar</th>
                        <th>Pseudo</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Vies</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>#{{ $init }}</td>
                                <td>
                                    <img src='../public/img/avatars/{{ $user->avatar }}.png'>
                                </td>
                                <td>{{ $user->pseudo }}</td>
                                <td>{{ $user->nom }}</td>
                                <td>{{ $user->prenom }}</td>
                                <td>{{ $user->vie }}</td>
                            </tr>
                            <?php $init++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection