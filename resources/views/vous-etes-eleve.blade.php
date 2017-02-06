@extends('layouts.app')

@section('title')
    Tu  élève
@endsection

@section('h1')
    Tu es élève
@endsection

@section('breadcrumb')
    <li><strong>Tu es élève</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page">
	<div class="row">
	  <p class="col-sm-12">
		  Bonjour ! Je suis ton petit cartable. Avec moi, tu vas pouvoir apprendre en t'amusant un maximum. Si tu adores jouer, préviens-vite tes parents ! Si tu as déjà un compte, je t'attends pour me défier. À très vite !
	  </p>
	</div>
	<div class="row">
	  <h2>Tu veux savoir ce que tu peux faire ?</h2>
	</div>
	<div class="concept">
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/layers.svg" />
		  </span>
		  <h3>Beaucoup de jeux pour plus de fun</h3>
		</div>
		<p>
		  Il existe sur ce site beaucoup de jeux pour t'amuser un maximum. Il y a même un super bomberman qui t'attends. Mais avant cela, tu devras gagner des vies en faisant un peu d'exercices. Tu verras, c'est facile et rapide.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/cadenas.svg" />
		  </span>
		  <h3>Choisis ton propre personnage</h3>
		</div>
		<p>
		  D'ailleurs, j'ai créé pour toi des avatars. Ce sont des personnages qui vont t'accompagner tout au long de ton aventure. Entre un lion, un canard, un ours et même des super héros, choisis ton personnage qui te caractérise le mieux.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/dice.svg" />
		  </span>
		  <h3>Gagne des vies</h3>
		</div>
		<p>
		  Joues avec tes amis à Bomberman en gagnant des vies sur nos exercices. Rien de plus simple, en répondant aux questions posées, tu gagneras des vies qui te permettront de jouer à Bomberman ou même acheter des personnages.
		</p>
	  </div>
	  <div class="col-sm-6">
		<div class="concept-top">
		  <span class="concept-icon concept-icon-1">
			<img src="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/img/icons/atom.svg" />
		  </span>
		  <h3>Tu veux nous dire quelque chose ?</h3>
		</div>
		<p>
		  Préviens tes parents ou même ton enseignant. Un jeu te ferait plaisir ? Il n'aura plus qu'à <a href="https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/contact">nous contacter</a> !
		</p>
	  </div>
	</div>
</div>
@include('include.banner-connect')
@endsection
