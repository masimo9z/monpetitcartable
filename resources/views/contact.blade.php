@extends('layouts.app')

@section('title')
    Contactez-nous
@endsection

@section('h1')
    Contactez-nous
@endsection

@section('breadcrumb')
    <li><strong>Contactez-nous</strong></li>
@endsection

@section('content')
    <div class="container-fluid global-page">
        <div class="col-sm-12">
            <div class="col-sm-12">
                {!! Form::open(['url' => 'contact']) !!}
                    <div class="col-md-6 form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                        {!! Form::label('nom', 'Votre nom : ') !!}
                        {!! Form::text('nom', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('nom', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="col-md-6 form-group {!! $errors->has('prenom') ? 'has-error' : '' !!}">
                        {!! Form::label('prenom', 'Votre prénom : ') !!}
                        {!! Form::text('prenom', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('prenom', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="col-md-12 form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                        {!! Form::label('email', 'Votre email : ') !!}
                        {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="col-md-12 form-group {!! $errors->has('sujet') ? 'has-error' : '' !!}">
                        {!! Form::label('sujet', 'Votre sujet : ') !!}
                        {!! Form::select('sujet', ['- Choisir un sujet -','Question', 'Proposer une idée', 'Signaler un bug', 'Contribuer au projet', 'Faire un don','Autre'], null, ['class' => 'form-control width-auto']) !!}
                        {!! $errors->first('sujet', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="col-md-12 form-group {!! $errors->has('message') ? 'has-error' : '' !!}">
                        {!! Form::label('message', 'Votre message : ') !!}
                        {!! Form::textarea ('message', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('message', '<small class="help-block">:message</small>') !!}
                    </div>
                    <div class="clr"></div>
                    <div class="col-sm-12">
                        {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection