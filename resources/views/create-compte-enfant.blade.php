@extends('layouts.app')

@section('id-page')
createaccountkid
@endsection
@section('class-page')
createaccountkid
@endsection

@section('title')
    Créer le compte de votre enfant
@endsection

@section('h1')
    Créer le compte de votre enfant
@endsection

@section('breadcrumb')
    <li><a href="{{ url('/compte') }}">Votre compte</a></li>
    <li><strong>Créer le compte de votre enfant</strong></li>
@endsection

@section('content')
<div class="container-fluid global-page">
    <p>Un mot de passe sera généré automatiquement.</p>
    <form role="form" method="POST" action="{{ url('/create-compte-enfant') }}">
        {{ csrf_field() }}    
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                <label for="nom" class="control-label">Nom de votre enfant :</label>
                <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom') }}">
                @if ($errors->has('nom'))
                <span class="help-block">
                    <strong>{{ $errors->first('nom') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                <label for="prenom" class="control-label">Prénom de votre enfant :</label>
                <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">

                @if ($errors->has('prenom'))
                <span class="help-block">
                    <strong>{{ $errors->first('prenom') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
                <label for="pseudo" class="control-label">Pseudo de votre enfant :</label>
                <input id="pseudo" type="text" class="form-control" name="pseudo" value="{{ old('pseudo') }}">
                @if ($errors->has('pseudo'))
                <span class="help-block">
                    <strong>{{ $errors->first('pseudo') }}</strong>
                </span>
                @endif
            </div>
            
            <div class="form-group{{ $errors->has('classe') ? ' has error' : '' }}">
                <label for="classe" class="control-label">Indiquez la classe de votre enfant :</label>
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
        </div>

        <div class="col-sm-6">
            <fieldset class="form-group{{ $errors->has('genre') ? ' has error' : '' }}">
                <legend>{!! Form::label('radios', 'Genre (facultatif) :', ['class' => 'control-label']) !!}</legend>
                <div class="form-check">
                    {!! Form::radio('genre', '1', true, ['id' => 'radio1', 'class' => 'form-check-input']) !!}
                    {!! Form::label('radio1', 'Garçon', ['class' => 'form-check-label']) !!}
                </div>                
                <div class="form-check">
                    {!! Form::radio('genre', '2', false, ['id' => 'radio2', 'class' => 'form-check-input']) !!}
                    {!! Form::label('radio2', 'Fille', ['class' => 'form-check-label']) !!}
                </div>
            </fieldset>
            
            <div class="form-group{{ $errors->has('date_naissance') ? ' has-error' : '' }}">
                <label for="date_naissance" class="control-label">Date de naissance (facultatif) :</label>
                <input id="date_naissance" type="date" class="form-control" name="date_naissance">
                @if ($errors->has('date_naissance'))
                <span class="help-block">
                    <strong>{{ $errors->first('date_naissance') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6 col-md-offset-6">
                    <button type="submit" class="btn btn-primary">
                        Générer le mot de passe et créer le compte de l'enfant
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>     
@endsection