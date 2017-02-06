<div class="banner banner2">
  <div class="container-fluid">
    <div class="banner-select">
        @if (Auth::guest())
          <a href="#connexion" type="button" class="btn btn-info">Connexion</a>
          <a href="#inscription" type="button" class="btn btn-info">Inscription</a> 
        @else
            @if (Auth::user()->groupe == '1')
                <h3>Accède à ton compte</h3>
                <li type="button" class="btn btn-info"><a href="{{url('/compte')}}">Mon compte</a></li>
              @elseif (Auth::user()->groupe == '2' || Auth::user()->groupe == '3')
                <h3>Accèdez à votre compte</h3>
                <li type="button" class="btn btn-info"><a href="{{url('/compte')}}">Votre compte</a></li>
              @endif
        @endif
    </div>
  </div>
</div>