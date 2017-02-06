@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ url('/compte') }}">Compte enseignant</a></li>
    <li><strong>Créer une classe</strong></li>
@endsection

@section('h1')
    Créer une classe
@endsection

@section('content')
<div class="container-fluid global-page">
    <div class="row">
        <p>Un mot de passe sera généré automatiquement.</p>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/create-classe') }}">
            {{ csrf_field() }}
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('ecole') ? ' has-error' : '' }}">
                    <label for="ecole">Quel est le nom de votre école ?</label>
                    <input id="ecole" type="text" class="form-control" name="ecole" value="{{ old('ecole') }}">
                    @if ($errors->has('ecole'))
                    <span class="help-block">
                        <strong>{{ $errors->first('ecole') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('nbreleve') ? ' has-error' : '' }}">
                    <label for="nbreleve">Combien d'élèves avez-vous ? (max : 50)</label>
                        <input id="nbreleve" type="number" class="form-control" name="nbreleve" value="{{ old('nbreleve') }}">
                        @if ($errors->has('nbreleve'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nbreleve') }}</strong>
                        </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('prefixe') ? ' has-error' : '' }}">
                    <label for="prefixe">Choisissez un préfixe de pseudo de vos élèves :</label>
                    <input id="prefixe" type="text" class="form-control" name="prefixe" value="{{ old('prefixe') }}">

                    @if ($errors->has('prefixe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('prefixe') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('classe') ? ' has error' : '' }}">
                    <label for="classe">Quelle classe avez-vous ?</label>
                    <select name="classe" class="form-control">
                        <option value="1">CP</option>
                        <option value="2">CE1</option>
                        <option value="3">CE2</option>
                        <option value="4">CM1</option>
                        <option value="5">CM2</option>
                    </select>
                    @if ($errors->has('classe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('classe') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                           Générer les comptes des élèves et créer une classe
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection