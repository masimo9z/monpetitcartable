
    <header>
        <div class="header-wrap">
          <div class="header-top row">
            @if (\Request::is('/'))
              <a href="{{ url('/') }}"><h1 class="logo col-sm-4"><img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/logo-mascotte.png" />Mon petit cartable</h1></a>
            @else
              <a href="{{ url('/') }}"><span class="logo col-sm-4"><img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/logo-mascotte.png" />Mon petit cartable</span></a>
            @endif

            @if (Auth::guest())
                <div class="connection col-lg-4 pull-right text-right">
                  <div class="connection-button">

<a href="#connexion" type="button" class="btn btn-primary">Connexion</a>
<div id="connexion" class="modalDialog">
	<div>
		<div class="modal-header">
            <a href="#close" title="Close" type="button" class="close"><span aria-hidden="true">&times;</span></a>
            <h4 class="modal-title">Connexion</h4>
        </div>
        <div class="modal-body">
            @if (session('messageErreurPopup'))
                <div class="alert alert-info" role="alert" id="messageDeconnexion">
                    {{ session('messageErreurPopup') }}
                </div>
            @endif
            @include('auth.login')
        </div>
	</div>
</div>
<a href="#inscription" type="button" class="btn btn-primary">Inscription</a>
<div id="inscription" class="modalDialog">
	<div>
		<div class="modal-header">
            <a href="#close" title="Close" type="button" class="close"><span aria-hidden="true">&times;</span></a>
            <h4 class="modal-title">Inscription</h4>
        </div>
        <div class="modal-body">
            @include('auth.register')
        </div>
	</div>
</div>
                  </div>
                  <span class="connection-user">13 utilisateurs connectés</span>
                </div>
            @else
                <div class="compte col-lg-4 pull-right">
                  <div class="col-sm-12">
                      <div class="pull-left">
                        <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/avatars/{{ Auth::user()->avatar }}.png"/>
                      </div>
                      <div class="pull-left top-infos">
                          <span>Bonjour {{ Auth::user()->pseudo }},</span>
                          <span>{{ Auth::user()->vie }} <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" class="icon-vies"/></span>
                          <a href="{{ url('/boutique') }}">Accéder à la boutique</a>
                      </div>
                      <div class="pull-right">
                        <a href="{{ url('/deconnexion') }}"><img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/logout.png"/></a>
                      </div>
                  </div>
                  <div class="col-sm-12 connection-button">
                      @if (Auth::user()->groupe == '1')
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/compte')}}">Mon compte</a></li>
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/classement')}}">Mon classement</a></li>
                      @elseif (Auth::user()->groupe == '2')
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/compte')}}">Votre compte</a></li>
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/compte#vos-classes')}}">Votre(vos) classe(s)</a></li>
                        <!-- <div class="links-list pull-left"><?php /* echo mySchool(); */ ?></div> -->
                      @elseif (Auth::user()->groupe == '3')
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/compte')}}">Votre compte</a></li>
                        <li type="button" class="btn btn-primary pull-left"><a href="{{url('/compte#vos-enfants')}}">Votre(vos) enfant(s)</a></li>
                        <!-- <div class="links-list pull-left"><?php /* echo myFamily(); */ ?></div> -->
                      @endif
                  </div>
                </div>
            @endif

          </div>
        </div>

        @include('include/menu', [$objectMatieres = array(
            0 => array(
                'href' => 'mathematiques',
                'name' => 'mathématiques',
                'Name' => 'Mathématiques'
            ),
            1 => array(
                'href' => 'francais',
                'name' => 'Français',
                'Name' => 'Français'
            ),
            2 => array(
                'href' => 'geographie',
                'name' => 'Géographie',
                'Name' => 'Géographie'
            )
        ),
        $objectNiveaux = array(
            0 => array(
                'name' => 'cp',
                'Name' => 'CP'
            ),
            1 => array(
                'name' => 'ce1',
                'Name' => 'CE1'
            ),
            2 => array(
                'name' => 'ce2',
                'Name' => 'CE2'
            ),
            3 => array(
                'name' => 'cm1',
                'Name' => 'CM1'
            ),
            4 => array(
                'name' => 'cm2',
                'Name' => 'CM2'
            )
        )])

    </header>
