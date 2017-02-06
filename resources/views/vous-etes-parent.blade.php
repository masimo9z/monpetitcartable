@extends('layouts.app')

@section('title')
    Vous êtes parent
@endsection

@section('h1')
    Vous êtes parent
@endsection

@section('breadcrumb')
    <li><strong>Vous êtes parent</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page">
	<div class="row">
	  <p class="col-sm-12">
		Mon petit cartable vous offre la possibilité de gérer le(s) compte(s) de votre(vos) enfant(s). En tant que parent, vous pourrez donner accès à votre(vos) enfant(s) à l'interface afin de lui permettre d'apprendre en s'amusant.
	  </p>
	</div>
	<div class="row">
	  <h2>Les avantages d'être parent</h2>
	</div>
	<div class="concept">
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/layers.svg" />
		  </span>
		  <h3>Gestion de compte(s) enfant(s)</h3>
		</div>
		<p>
		  Avec notre outil, il ne vous faudra que quelques minutes pour permettre à vos enfants d'accéder à leur propre compte. Vous pourrez accéder aux résultats et ainsi voir les lacunes de vos enfants.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cadenas.svg" />
		  </span>
		  <h3>Une nouvelle méthode d'apprentissage</h3>
		</div>
		<p>
		  Compliqué de prendre du plaisir à faire ses devoirs. Et pourtant, grâce à mon petit cartable, apprendre les additions, grammaire ou encore histoire de France devient un jeu d'enfant ! Grâce à des jeux éducatifs, votre enfant pourra progresser en s'amusant.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/dice.svg" />
		  </span>
		  <h3>Des jeux pour tous les niveaux</h3>
		</div>
		<p>
		  Les niveaux vont du CP au CM2. C'est pourquoi, lors de la création d'un compte enfant, il est important de bien choisir le bon niveau de son enfant. Nous nous basons sur les programmes nationaux afin de satisfaire un maximum les besoins éducatifs de chacun.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/atom.svg" />
		  </span>
		  <h3>Des suggestions ?</h3>
		</div>
		<p>
		  En tant que parent, votre avis compte. Faîtes-nous parvenir vos suggestions d'améliorations ou propositions permettant à mon petit cartable d'innover le quotidien scolaire de vos enfants. <a href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/contact">Contactez-nous</a> !
		</p>
	  </div>
	</div>
</div>
@include('include.banner-connect')
@endsection
