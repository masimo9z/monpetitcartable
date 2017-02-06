@extends('layouts.app')

@section('breadcrumb')
    <li><strong>Compléter votre profil</strong></li>
@endsection

@section('h1')
    Compléter votre profil
@endsection

@section('content')
<div class="container-fluid global-page">
    <div class="row">
        <p>Vous devez compléter votre profil pour pouvoir poursuivre la navigation sur le site.</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/infos-incomplete') }}">
            {{ csrf_field() }}
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('groupe') ? ' has error' : '' }}">
                    <label for="groupe">Vous-êtes ?</label>
                    <select name="groupe" class="form-control">
                        <option value="2">Un enseignant</option>
                        <option value="3">Un parent</option>
                    </select>
                    @if ($errors->has('groupe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('groupe') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                    <label for="nom">Votre nom ?</label>
                    <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom') }}">
                    @if ($errors->has('nom'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nom') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                    <label for="prenom">Votre prénom ?</label>
                    <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">
                    @if ($errors->has('prenom'))
                    <span class="help-block">
                        <strong>{{ $errors->first('prenom') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Finaliser mon inscription
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection