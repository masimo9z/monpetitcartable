@extends('layouts.app')

@section('title')
    Qui-sommes-nous ?
@endsection

@section('h1')
    Qui-sommes-nous ?
@endsection

@section('breadcrumb')
    <li><strong>Qui-sommes-nous ?</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page">
    <div class="row">
      <p class="col-sm-12">
        Nous sommes une équipe de 4 étudiants en licence professionnelle TAIS (Techniques et Activités de l'Image et du Son) dans un parcours de développement web à l'IUT d'Haguenau. Notre passion est la conception de sites web. Nous tenons à remercier enseignants et vacataires pour leur pédagogie.
      </p>
    </div>
    <div class="row">
      <h2>Une équipe de développeurs</h2>
    </div>
  </div><!-- end global-page -->

  <div class="banner">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 team">
          <img src="img/avatars/3.png" />
          <span class="teammate">Hugo</span>
        </div>
        <div class="col-sm-3 team">
          <img src="img/avatars/5.png" />
          <span class="teammate">Jordan</span>
        </div>
        <div class="col-sm-3 team">
          <img src="img/avatars/4.png" />
          <span class="teammate">Masinissa</span>
        </div>
        <div class="col-sm-3 team">
          <img src="img/avatars/2.png" />
          <span class="teammate">Patricia</span>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid global-page"><!-- New global-page -->
    <div class="concept">
      <div class="col-sm-6">
        <div class="concept-top">
          <span class="concept-icon concept-icon-1">
            <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/layers.svg" />
          </span>
          <h3>La touche graphique d'Hugo</h3>
        </div>
        <p>
          Hugo est notre designer intégrateur. Il est l'auteur des diverses touches artistiques présentes sur le site (avatars, interface utilisateur, ...). Avec un esprit digne de Picasso, Hugo adore bouquiner, dessiner et chanter. Quel artiste !
        </p>
      </div>
      <div class="col-sm-6">
        <div class="concept-top">
          <span class="concept-icon concept-icon-1">
            <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cadenas.svg" />
          </span>
          <h3>Le côté fonctionnel de Jordan</h3>
        </div>
        <p>
          Jordan est notre développeur web. Il s'est chargé des fonctionnalités permettant les diverses actions sur le site (connexion, commentaires, notes...). Son seul objectif est la réussite. Avec lui, tout devient fonctionnel !
        </p>
      </div>
      <div class="col-sm-6">
        <div class="concept-top">
          <span class="concept-icon concept-icon-1">
            <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/dice.svg" />
          </span>
          <h3>Masinissa, le maître du jeu</h3>
        </div>
        <p>
          Masinissa est également développeur web. Concevoir vos jeux préférés est sa passion. Très motivé et motivant, il pourrait presque diriger un pays à lui tout-seul. Grâce à lui, jouer devient un jeu d'enfant !
        </p>
      </div>
      <div class="col-sm-6">
        <div class="concept-top">
          <span class="concept-icon concept-icon-1">
            <img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/atom.svg" />
          </span>
          <h3>L'adaptation selon Patricia</h3>
        </div>
        <p>
          Patricia est notre intégratrice et développeuse. Elle s'est occupée avec Hugo de mettre en forme Mon petit cartable et également de nombreuses fonctionnalités. Vous ne pourrez jamais la prendre au dépourvu. Très maline, elle a quoi qu'il arrive toujours plus d'un tour dans son sac !
        </p>
      </div>
    </div>
</div>
@include('include.banner-connect')
@endsection
