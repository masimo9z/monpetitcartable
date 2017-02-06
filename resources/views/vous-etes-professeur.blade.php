@extends('layouts.app')

@section('title')
    Vous êtes professeur
@endsection

@section('h1')
    Vous êtes professeur
@endsection

@section('breadcrumb')
    <li><strong>Vous êtes professeur</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page">
	<div class="row">
	  <p class="col-sm-12">
		  Mon petit cartable vous offre la possibilité de gérer votre propre classe. En tant qu'enseignant, vous pourrez créer votre section et par conséquent les comptes de vos élèves en fonction du niveau (CP, CE1, CE2, CM1 ou CM2). Contrôlez à distance depuis votre espace personnel les résultats de vos élèves.
	  </p>
	</div>
	<div class="row">
	  <h2>Les avantages d'être professeur</h2>
	</div>
	<div class="concept">
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/layers.svg" />
		  </span>
		  <h3>Gestion de classe(s)</h3>
		</div>
		<p>
		  Vous êtes enseignant de plusieurs sections ? Pas de panique ! Sur mon petit cartable, il est possible de créer une multitude de classes. Des identifiants gérés par nos services vous permettront d'accéder au compte des élèves.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cadenas.svg" />
		  </span>
		  <h3>Un nouvel outil dans votre programme</h3>
		</div>
		<p>
		  Pourquoi ne pas utiliser Mon petit cartable dans votre enseignement ? Rien de mieux pour détendre vos élèves que d'apprendre tout en s'amusant. En nous basant sur les programmes nationaux, nos jeux sont parfaitement adaptés aux divers niveaux d'une classe.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/dice.svg" />
		  </span>
		  <h3>Différentes matières pour tous les niveaux</h3>
		</div>
		<p>
		  Mon petit cartable propose à vos élèves trois matières : les mathématiques, le français et la géographie. Les exercices sont généralement communs mais s'adaptent selon le niveau de votre classe.
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
		  En tant qu'enseignant, votre avis compte. Faîtes-nous parvenir vos suggestions d'améliorations ou propositions permettant à Mon petit cartable d'innover le quotidien scolaire de vos élèves. <a href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/contact">Contactez-nous</a> !
		</p>
	  </div>
	</div>
</div>
@include('include.banner-connect')
@endsection
