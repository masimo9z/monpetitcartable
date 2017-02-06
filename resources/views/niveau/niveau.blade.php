@extends('layouts.app')

@section('id-page'){{ $classe }}@endsection
@section('class-page'){{'programme'}}@endsection

@section('title')
    {{ $objectNiveaux[rankObjectNiveau()]['Name'] }}
@endsection

@section('h1')
    Mon petit cartable de {{ $objectNiveaux[rankObjectNiveau()]['Name'] }}
@endsection

@section('breadcrumb')
    <li><strong>{{ $objectNiveaux[rankObjectNiveau()]['Name'] }}</strong></li>
@endsection

@section('content')

    <div class="container-fluid global-page">
        <div class="row">
            <div class="col-md-12">
                @if ($classe == 'cp')
                    <p>Le CP marque l'entrée d'un élève à l'école primaire. C'est le début de l'enseignement de la lecture, l'écriture ou la communication. L'objectif est d'apprendre un maximum de bases qui seront retravaillées puis perfectionnées en CE1.</p>
                
                    <p>En suivant le programme national imposé aux élèves de CP, Mon petit cartable leur propose de travailler les additions et développer leur logique à l'aide de différents types de jeux. Nous leur proposons également d'apprendre la grammaire, tout en s'amusant.</p>
                
                @elseif ($classe == 'ce1')
                    <p>Le CE1 est la deuxième année d'un élève à l'école primaire. A la fin de l'année, l'élève doit pouvoir maîtriser les bases du français et des mathématiques afin d'approfondir ses premières connaissances à partir du CE2.</p>
                
                    <p>En suivant le programme national imposé aux élèves de CE1, Mon petit cartable leur propose de travailler les additions, les soustractions et développer leur logique à l'aide de différents types de jeux. Nous leur proposons également d'apprendre la grammaire, tout en s'amusant.</p>
                
                @elseif ($classe == 'ce2')
                    <p>Le CE2 est la troisième année d'un élève à l'école primaire. Il marque le début d'un cycle d'approfondissement des acquis des deux premières années. C'est lors de cette année que l'enseignant va identifier les lacunes de ses élèves.</p>
                
                    <p>En suivant le programme national imposé aux élèves de CE2, Mon petit cartable leur propose de travailler les additions, les soustractions et développer leur logique à l'aide de différents types de jeux. Nous leur proposons également d'apprendre la grammaire, tout en s'amusant.</p>
                
                @elseif ($classe == 'cm1')
                
                     <p>Quatrième et avant dernière année à l'école primaire, le CM1 est la suite du cycle débuté au CE2. Il permet de tester l'autonomie de travail d'un élève.</p>
                
                    <p>En suivant le programme national imposé aux élèves de CM1, Mon petit cartable leur propose de travailler les additions, les soustractions et développer leur logique à l'aide de différents types de jeux. Nous leur proposons également d'apprendre la grammaire, tout en s'amusant.</p>
                
                @elseif ($classe == 'cm2')
                    <p>Le CM2 est la dernière classe de l'école primaire. Il marque également la fin du cycle d'approfondissement avant l'entrée au niveau supérieur qu'est le collège. Il va falloir s'y préparer.</p>
                
                    <p>En suivant le programme national imposé aux élèves de CM2, Mon petit cartable leur propose de travailler les additions, les soustractions, les multiplications et développer leur logique à l'aide de différents types de jeux. Nous leur proposons également d'apprendre la grammaire, tout en s'amusant.</p>
                @endif

                <h2>Choisis la matière que tu veux étudier : </h2>
                <div class="matieres text-center">
                    @foreach ($objectMatieres as $objectMatiere)
                        <a href="{{ url('/programme/'.$classe.'/'.$objectMatiere['href']) }}" type="button" class="btn btn-ghost">{{ $objectMatiere['Name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="banner banner2">
      <div class="container-fluid">
        <div class="banner-select">
          <h3>Nos autres niveaux</h3>
            @foreach ($objectNiveaux as $objectNiveau)
                @if ($objectNiveau['name'] != $classe)
                    <a href="{{ url('/programme/'.$objectNiveau['name']) }}" type="button" class="btn btn-info">{{ $objectNiveau['Name'] }}</a>
                @endif
            @endforeach
        </div>
      </div>
    </div>
@endsection