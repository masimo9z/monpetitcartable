<script src="https://www.google.com/recaptcha/api.js" async defer></script>

    {!! Form::open(['class' => 'test', 'url' => 'inscription']) !!}

        <h2>Champs obligatoires :</h2>
    
        {!! Form::label('pseudo', 'Pseudo : ') !!}
        {!! Form::text('pseudo') !!}
    
        <br /><br />

        {!! Form::label('password', 'Mot de passe : ') !!}
        {!! Form::password('password') !!}

        <br /><br />

        {!! Form::label('pass-confirm', 'Confirmer votre mot de passe : ') !!}
        {!! Form::password('pass-confirm') !!}

        <br /><br />

        {!! Form::label('email', 'Email : ') !!}
        {!! Form::email('email') !!}

        <br /><br />
        
        {!! Form::label('enseignant', 'Enseignant') !!}
        {!! Form::radio('groupe', 'enseignant') !!}

        {!! Form::label('eleve', 'Elève') !!}
        {!! Form::radio('groupe', 'eleve') !!}
        
        {!! Form::label('parent', 'Parents') !!}
        {!! Form::radio('groupe', 'parent') !!}
        <br /><br />

        <h2>Champs optionnels :</h2>

        {!! Form::label('sexe', 'Garçon') !!}
        {!! Form::radio('sexe', 'garcon') !!}
        {!! Form::label('sexe', 'Fille') !!}
        {!! Form::radio('sexe', 'fille') !!}

        <br /><br />

        {!! Form::label('date_naissance', 'Date de naissance') !!}
        {!! Form::date('date_naissance') !!}

        <br /><br />

        <div class="g-recaptcha" data-sitekey="6LcxpggUAAAAAHFaQwzpY8o5VOSCnOcZqW1ztShP"></div>
        
        <br /><br />

        {!! Form::submit('S\'inscrire !') !!}
    {!! Form::close() !!}


<script type="text/javascript">
    var onloadCallback = function() {
        alert("grecaptcha is ready!");
    };
</script>