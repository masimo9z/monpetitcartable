@section('titre')
    Connexion à Mon Petit Cartable
@stop

@section('h1')
    Connexion
@stop

@section('contenu')
   <div class="row">
        <form class="col-sm-8 col-sm-offset-2" role="form" method="POST" action="{{ url('/connexion') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Pseudo</label>

                <div class="">
                    <input id="pseudo" type="pseudo" class="form-control" name="pseudo" value="{{ old('pseudo') }}">

                    @if ($errors->has('pseudo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pseudo') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Mot de passe</label>

                <div class="">
                    <input id="password" type="password" class="form-control" name="password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> Login
                    </button>

                    <a class="btn btn-info" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                    <span class="connection-select">
                        <hr/>
                        <p>Ou</p>
                    </span>

                    <a class="btn btn-info btn-facebook" data-max-rows="1" data-size="medium" data-show-faces="false" href="auth/facebook" data-auto-logout-link="false">Connexion à Facebook</a>
                </div>
            </div>
        </form>
    </div>
@endsection


