@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row boutique">

        <div class="col-sm-12">
          <h2>Acheter des avatars</h2>
          <p class="col-sm-12">
            Vous avez : {{ Auth::user()->vie }} <img class="vies" src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" />
          </p>
          @foreach($avatars as $avatar)
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="col-sm-12 avatar-carte">
                  <div class="col-sm-6 pull-left">
                    <img src="img/avatars/{{ $avatar->id_avatar }}.png" class="avatar">
                  </div>
                  <div class="col-sm-6">
                      <p>
                        <strong>{{ $avatar->nom_avatar }}</strong>
                      </p>
                      <p>
                        Prix : <strong>{{ $avatar->prix }}</strong> <img class="vies" src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg" />
                      </p>
                      <?php
                      if(Auth::user()->vie >= $avatar->prix){
                          ?>
                          <form class="form-horizontal col-sm-6" role="form" method="POST" action="{{ url('/boutique') }}">
                                  <div class="form-group">
                                      <div class="">
                                          <input type="hidden" name="choice" value="{{ $avatar->id_avatar }}">
                                          <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                          <button type="submit" class="btn btn-primary">
                                              Acheter
                                          </button>
                                      </div>
                                  </div>
                          </form>
                          <?php
                      }
                      else
                      {
                          echo "<p>
                          Pas assez de <img class='vies' src='https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cartes-vies.svg' />
                          </p>";
                      }
                      ?>
                  </div>
                </div>
              </div>
          @endforeach


        </div>
    </div>
</div>

@endsection
