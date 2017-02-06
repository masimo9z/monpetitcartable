<div class="row">
    <form class="col-sm-10 col-sm-offset-1" role="form" method="POST" action="{{ url('/connexion') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
            <label for="pseudo" class="col-sm-12 control-label ">Pseudo</label>

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
            <label for="password" class="col-sm-12 control-label">Mot de passe</label>

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
                        <input type="checkbox" name="remember"> Se souvenir de moi
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <div class="">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> Se connecter
                </button>

                <a class="btn btn-primary" href="{{ url('/password/reset') }}">Mot de passe oublié?</a>
                <span class="connection-select">
                    <hr/>
                    <p>Ou</p>
                </span>

                <a class="btn btn-info btn-facebook" data-max-rows="1" data-size="medium" data-show-faces="false" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/auth/facebook" data-auto-logout-link="false">Connexion à Facebook</a>
            </div>
        </div>
    </form>
</div>
