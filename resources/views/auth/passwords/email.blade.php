@extends('layouts.app')

@section('title')
    Mot de passe oublié
@endsection

@section('h1')
    Mot de passe oublié
@endsection

@section('breadcrumb')
    <li><strong>Mot de passe oublié</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="col-sm-12">
        
        <div class="col-sm-12">     
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" role="form" action="">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">Votre E-mail</label>

                    <div class="">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-envelope"></i> Envoyer un lien de renouvellement de mdp
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
        
    </div>
</div>
@endsection
