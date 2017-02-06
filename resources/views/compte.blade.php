@extends('layouts.app')

@section('breadcrumb')
    <?php
        if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){ ?>
            <li><strong>Votre compte</strong></li>
    <?php
        }
        else if(Auth::user()->groupe == 1){
            ?>
            <li><strong>Mon compte</strong></li>
    <?php
        }
    ?>
@endsection

@section('title')
    <?php
        if(Auth::user()->groupe == 2){
            ?>
            Compte enseignant
            <?php
        }
        else if(Auth::user()->groupe == 3){
            ?>
            Compte parent
            <?php
        }
        else if(Auth::user()->groupe == 1){
            ?>
            Mon compte
            <?php
        }
    ?>
@stop

@section('content')
<div class="container-fluid global-page">
    <div class="row">
        <?php
            if(Auth::user()->groupe == 2){
                ?>
                <h1>Votre compte enseignant</h1>
                <?php
            }
            else if(Auth::user()->groupe == 3){
                ?>
                <h1>Votre compte parent</h1>
                <?php
            }
            else if(Auth::user()->groupe == 1){
                ?>
                <h1>Mon compte</h1>
                <?php
            }
        ?>
    </div>
    <div class="row">
        <?php
            if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
        ?>
            <h2>Vos informations</h2>
            <div class="col-sm-6">
                <p>Bonjour <span class="colored-blue"> {{ Auth::user()->nom }} {{ Auth::user()->prenom }}, </span></p>
                <ul>
                    <li>Votre pseudo : <span class="colored-blue">{{ Auth::user()->pseudo }}</span></li>
                    <li>Votre email : <span class="colored-blue">{{ Auth::user()->email }}</span></li>
                    <?php
                        if(Auth::user()->groupe == 2){
                            ?>
                            <li>Vous êtes : <span class="colored-blue">Enseignant</span></li>
                            <?php
                        }
                        else if(Auth::user()->groupe == 3){
                            ?>
                            <li>Vous êtes : <span class="colored-blue">Parent</span></li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        <?php
            }
            else if(Auth::user()->groupe == 1){
        ?>
            <h2>Mes informations</h2>
            <div class="col-sm-6">
                <p>Bonjour <span class="colored-blue"> {{ Auth::user()->nom }} {{ Auth::user()->prenom }}, </span></p>
                <ul>
                    <li>Mon pseudo : <span class="colored-blue">{{ Auth::user()->pseudo }}</span></li>
                    <li>Je suis : <span class="colored-blue">Elève</span></li>
                </ul>
            </div>
        <?php
            }
        ?>
        <div class="col-sm-6">
            {!! Form::open(['class' => 'test', 'url' => 'compte']) !!}
            <p>{!! Form::label('avatar', 'Changer ton avatar : ') !!}</p>
            <div class="avatar">
                <img src="../public/img/avatars/{{ Auth::user()->avatar }}.png" />
            </div>
            <div class="select-avatar form-group">
                <select name="avatar" class="form-control width-auto pull-left margin-right-15">
                    <option value="0">Aucun changement</option>
                    <option value="1">Mon petit cartable</option>
                    <option value="2">Mon petit ours</option>
                    <option value="3">Mon petit canard</option>
                    <option value="4">Mon petit chat</option>
                    <option value="5">Mon petit lion</option>
                    <?php 
                    $avatars_payants = DB::table('mpc_avatars')
                        ->leftJoin('mpc_boutique', 'mpc_avatars.id_avatar', '=', 'mpc_boutique.id_avatar')
                        ->where('id_membre', Auth::user()->id)
                        ->get();
                    
                    foreach($avatars_payants as $newavatar){
                        echo "<option value=".$newavatar->id_avatar.">".$newavatar->nom_avatar."</option>";
                    }
                    ?>
                </select>

           
            
            {!! Form::submit('Changer d\'avatar', ['class' => 'btn btn-primary']) !!}
                 </div>
            {!! Form::close() !!}
            <div><a href="{{url('/boutique')}}" class="btn btn-form">Acheter de nouveaux avatars</a></div>
        </div>
    </div>
    <hr/>

     <?php
        if(Auth::user()->groupe == 2){
            ?>
      <div id="vos-classes">
          <h2>Accédez à votre(vos) classe(s)</h2>
          <div class="container-fluid compte-classe">
              <p>Accédez à votre(vos) classe(s)</p>
              <div class="row">
                <span class="my-school"><?php echo mySchool(); ?></span>
              </div>
              <p>Créez une nouvelle classe</p>
              <div class="row">
                <a href='/projets/dweb02/laravel/monpetitcartable/public/create-classe' type="button" class="btn btn-form">Créer</a>
              </div>
          </div>
      </div>
        
            <hr/>
            <?php
        }
        else if(Auth::user()->groupe == 3){
            ?>
        <div id="vos-enfants">
            <h2>Votre(Vos) enfant(s)</h2>
          <div class="container-fluid compte-classe">
            <p>Votre(Vos) enfant(s)</p>
              <div class="row">
                <a href='https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/create-compte-enfant' type="button" class="btn btn-form">Créer un compte enfant</a>
              </div>
              <p>Accédez aux comptes de votre(vos) enfant(s)</p>
              <div class="row">
                <span class="my-school"><?php echo myFamily(); ?></span>
              </div>
          </div>
        </div>
            <hr/>
            <?php
        }
    ?>


    <div class="row">
        <?php
            if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
        ?>
        <h2>Modifier vos informations</h2>
        <div class="panel-body no-padding">
            <p class="padding-left-15">Souhaitez-vous modifier votre mot de passe ? Mini 5 caractères</p>
            <?php
        }
        else if(Auth::user()->groupe == 1){
            ?>
            <h2>Modifier mes informations</h2>
        <div class="panel-body no-padding">
            <p class="padding-left-15">Souhaites-tu modifier ton mot de passe ? Mini 5 caractères</p>
             <?php
        }
    ?>
            <form class="col-md-6 col-sm-6 col-xs-12" role="form" method="POST" action="{{ url('/comptemdp') }}">
                {{ csrf_field() }}
                
                <div class="form-group{{ $errors->has('newmdp') ? ' has-error' : '' }}">
                     <?php
                        if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
                    ?>
                        <label for="newmdp">Taper votre nouveau mot de passe : </label>
                    <?php
                        }
                        else if(Auth::user()->groupe == 1){
                    ?>
                        <label for="newmdp">Tape ton nouveau mot de passe : </label>
                    <?php
                        }
                    ?>
                    <input id="newmdp" type="password" class="form-control" name="newmdp" value="{{ old('newmdp') }}">
                    @if ($errors->has('newmdp'))
                    <span class="help-block">
                        <strong>{{ $errors->first('newmdp') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('newmdp-confirm') ? ' has-error' : '' }}">
                     <?php
                        if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
                    ?>
                    <label for="newmdp-confirm">Confirmer votre nouveau mot de passe : </label>
                    <?php
                        }
                        else if(Auth::user()->groupe == 1){
                            ?>
                                <label for="newmdp-confirm">Confirme ton nouveau mot de passe : </label>
                             <?php
                        }
                    ?>
                    <input id="newmdp-confirm" type="password" class="form-control" name="newmdp-confirm" value="{{ old('newmdp-confirm') }}">
                    @if ($errors->has('newmdp-confirm'))
                    <span class="help-block">
                        <strong>{{ $errors->first('newmdp-confirm') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group">
                    <div class="">
                        <?php
                            if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
                        ?>
                        <button type="submit" class="btn btn-primary">
                            Changer mon mot de passe
                        </button>
                        <?php
                            }
                            else if(Auth::user()->groupe == 1){
                                ?>
                                    <button type="submit" class="btn btn-primary">
                                        Change ton mot de passe
                                    </button>
                                 <?php
                            }
                        ?>
                    </div>
                </div>
            </form>
                
            
            <form class="col-md-6 col-sm-6 col-xs-12" role="form" method="POST" action="{{ url('/compteinfo') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                     <?php
                        if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
                    ?>
                        <label for="nom">Changer votre nom : </label>
                    <?php
                        }
                        else if(Auth::user()->groupe == 1){
                    ?>
                        <label for="nom">Change ton nom : </label>
                    <?php
                        }
                    ?>
                    <input id="nom" type="text" class="form-control" name="nom" value="{{ old('nom') }}">
                    @if ($errors->has('nom'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nom') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                     <?php
                        if(Auth::user()->groupe == 2 || Auth::user()->groupe == 3){
                    ?>
                        <label for="prenom">Changer votre prénom : </label>
                    <?php
                        }
                        else if(Auth::user()->groupe == 1){
                    ?>
                        <label for="prenom">Change ton prénom : </label>
                    <?php
                        }
                    ?>
                    <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">
                    @if ($errors->has('prenom'))
                    <span class="help-block">
                        <strong>{{ $errors->first('prenom') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
