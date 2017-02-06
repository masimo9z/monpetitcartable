@extends('layouts.app')

@section('title')
    Mentions légales
@endsection

@section('h1')
    Mentions légales
@endsection

@section('breadcrumb')
    <li><strong>Mentions légales</strong></li>
@endsection

<!-- Main Content -->
@section('content')
<div class="container-fluid global-page">
   <div class="field field-type-text-with-summary">
       <h2><strong>Informations éditeur</strong></h2>
       <p>Ce site Internet est la propriété de l'IUT d'Haguenau.</p>
       <p>Les mises à jour sont assurées par Messieurs FEGER, KADDOUR et STEHLI et Madame MARTIN.</p>
       <p>Pour toute suggestion, information, réaction concernant ce site, n’hésitez pas à écrire au webmestre via la page de contact.</p>
       <h2><strong>Informations générales</strong></h2>
       <div>
           <h3>Traitement des données personnelles (liste de diffusion) :</h3>
           <p>Votre adresse électronique (qui a fait l’objet d’une inscription volontaire) servira uniquement à acheminer notre réponse à votre question. Elle ne sera en aucun cas communiquée à des tiers.</p>
           <p>En application de l’article 27 de la loi Informatique et libertés en date du 6 février 1978, vous disposez d’un droit de modification et de suppression des données qui vous concernent. Pour cela, vous êtes libre, à tout moment, de nous le signaler via la page de contact.</p>
       </div> 
       <h2><strong>Informations techniques</strong></h2>
       <div>
           <h3>Création du site :</h3>
           <p>Messieurs FEGER, KADDOUR et STEHLI et Madame MARTIN</p>
           <h3>Hébergement du site :</h3>
           <ul>
                <li>IUT Haguenau</li>
                <li>30 avenue du Maire André Traband</li>
                <li>67500 Haguenau</li>
                <li>France</li>
                <li>Tel : +33 3 88 05 34 00</li>
                <li><a href="https://iuthaguenau.unistra.fr/" target="_blank">iuthaguenau.unistra.fr</a></li>
           </ul>
           <h3>Affichage et consultation des pages du site :</h3>
		   <p>L’affichage des pages du site est optimisé pour une résolution d’écran de 1024 x 768, dans une palette de 65536 couleurs.</p>
           <p>Nous vous recommandons la consultation de ces pages avec les principaux navigateurs Internet suivants :</p>
           <ul>
            <li>Microsoft Internet Explorer, version 10 et ultérieures,</li>
            <li>Mozilla Firefox 11 et ultérieures,</li>
            <li>Google Chrome</li>
            <li>Safari MAC/PC</li>
           </ul>
       </div> 
       <div>
        <h2><strong>Informations juridiques</strong></h2>
            <p>L’utilisateur du site s’engage pour sa part à respecter les règles suivantes :</p>
            <h3>Clause de non responsabilité</h3>
            <p>Le présent site ne peut garantir l’exactitude de toutes les informations contenues sur le site. Cependant, l’éditeur s’efforcera de diffuser des informations exactes et à jour, ainsi que de corriger les erreurs qui lui seront signalées.</p>
            <h3>Copyright</h3>
            <p>Dans le cadre d’un usage autre que strictement privé, ne pas résumer, modifier, altérer le contenu textuel ni les données cartographiques du site Internet sans autorisation préalable de l’éditeur. Les demandes doivent être adressées via le formulaire de contact.Pour un usage privé, la reproduction partielle sur support papier des données textuelles contenues sur le site est libre. Elle peut être réalisée sans autorisation de l’éditeur du site. Cette reproduction ne peut cependant être présentée comme une version officielle.</p>
            <p>L’autorisation de reproduire est accordée à l’utilisateur sans paiement de droits, sous réserve que le demandeur s´engage à citer le nom du propriétaire du site Internet et l´adresse du site Internet (avec un lien hypertexte) et sans modification.</p>
            <h3>Création de liens hypertextes</h3>
            <p>Il est possible de créer un lien vers le site sans autorisation expresse de l’éditeur, à la seule condition que ce lien ouvre une nouvelle fenêtre du navigateur Internet. Toutefois, l’éditeur se réserve le droit de demander la suppression d’un lien qu’il estime non conforme à sa politique éditoriale.</p>
       </div>
    </div>
</div>
@endsection
