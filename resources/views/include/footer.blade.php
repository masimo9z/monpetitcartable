 <footer>
    <div class="footer-wrap row">
        <div class="col-sm-15 col-xs-6 no-padding footer-info">
            <ul class="no-padding">
                <h3>Tu es</h3>
                <hr>
                <li><a href="{{ url('/vous-etes-professeur') }}">Un professeur</a></li>
                <li><a href="{{ url('/vous-etes-eleve') }}">Un élève</a></li>
                <li><a href="{{ url('/vous-etes-parent') }}">Un parent</a></li>
            </ul>
        </div>
        <div class="col-sm-15 col-sm-offset-15 col-xs-6 no-padding footer-info">
            <ul class="no-padding">
                <h3>Notre équipe</h3>
                <hr>
                <li><a href="{{ url('/qui-sommes-nous') }}">Qui sommes-nous ?</a></li>
                <li><a href="{{ url('/contact') }}">Contactez-nous</a></li>
            </ul>
        </div>
        <div class="col-sm-15 col-sm-offset-15 col-xs-6 no-padding footer-info">
            <ul class="no-padding social">
                <h3>Restez connectés</h3>
                <hr>
                <div class="social-responsive">
                  <li><a target="_blank" href="https://twitter.com/mypetitcartable"></a></li>
                  <li><a target="_blank" href="https://plus.google.com/u/1/100963279589575549327"></a></li>
                  <li><a target="_blank" href="https://www.facebook.com/Mon-petit-cartable-1823098064596623/"></a></li>
                </div>
            </ul>
        </div>
    </div>
     <div class="row text-center">
        <a href="{{ url('/mentions-legales') }}">Mentions légales</a> - <?php echo date("Y"); ?>
     </div>
</footer>