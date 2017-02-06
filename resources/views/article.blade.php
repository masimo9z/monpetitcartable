<!-- On récupère la structure du fichier Template.Blade.Php -->
@extends('template')

<!-- Définition du title -->
@section('titre')
    Les articles
@stop

<!-- Définition du content -->
@section('contenu')
    <p>C'est l'article n° {{ $numero }}</p>
@stop