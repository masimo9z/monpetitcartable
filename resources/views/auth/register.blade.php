<script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/inscription') }}">
            {{ csrf_field() }}

            <div class="col-md-6">
                <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                    <label for="nom" class="col-md-12 control-label padding-left-15">Nom</label>

                    <div class="col-md-12">
                        <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom') }}">

                        @if ($errors->has('nom'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nom') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                    <label for="prenom" class="col-md-12 control-label padding-left-15">Prénom</label>

                    <div class="col-md-12">
                        <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">

                        @if ($errors->has('prenom'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prenom') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-12 control-label padding-left-15">Pseudo</label>

                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-12 control-label padding-left-15">Adresse E-Mail</label>

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email"  value="{{ old('email') }}">

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-12 control-label padding-left-15">Mot de passe</label>

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="col-md-12 control-label padding-left-15">Confirmer votre mot de passe</label>

                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control"   name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('groupe') ? ' has error' : '' }}">
                    <label for="groupe" class="col-md-12 control-label padding-left-15">Vous êtes :</label>

                    <div class="col-md-12">
                        <select name="groupe" class="form-control">
                            <option value="2">Professeur</option>
                            <option value="3">Parent</option>
                        </select>
                    </div>

                    @if ($errors->has('groupe'))
                    <span class="help-block">
                        <strong>{{ $errors->first('groupe') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div style="margin: 20px auto; width: 300px; " class="g-recaptcha" data-sitekey="6LcxpggUAAAAAHFaQwzpY8o5VOSCnOcZqW1ztShP"></div>
                @if ($errors->has('g-recaptcha-response'))
                <span class="help-block">
                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                </span>
                @endif
            </div>


            <div class="form-group">
                <div class="col-md-5 col-md-offset-5">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> S'inscrire
                    </button>
				
					<span class="connection-select">
						<hr/>
						<p>Ou</p>
					</span>

					<a class="btn btn-info btn-facebook" data-max-rows="1" data-size="medium" data-show-faces="false" href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/auth/facebook" data-auto-logout-link="false">S'inscrire avec Facebook</a>            
                </div>
            </div>
        </form>

<script type="text/javascript">
    var onloadCallback = function() {
        alert("grecaptcha is ready!");
    };
    var onloadCallback = function() {
        alert("grecaptcha is ready!");
    };
</script>
