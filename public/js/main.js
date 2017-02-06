jQuery(document).ready(function () {
    //Pour pages matieres : ajout de la classe active sur la matière sélectionnée dans le menu à gauche

jQuery(".compte .pull-right img").hover(function(){
    jQuery(this).attr("src", function(index, attr){
        return attr.replace(".png", "-hover.png");
    });
}, function(){
    jQuery(this).attr("src", function(index, attr){
        return attr.replace("-hover.png", ".png");
    });
});
  
var labels = jQuery("#ranks label");

labels.hover(function(){
  jQuery(this).css("color", "white")
    .prevUntil().css("color", "white");

}, function(){
    jQuery(this).css("color", "inherit").prevUntil().css("color", "inherit");
    var checkedNum = jQuery("#ranks label.checked").length;
});


labels.click(function(){
  var labelSelected = jQuery(this);
  // reset label class and input checkbox
  labels.removeClass("rankChecked checked")
    .find("input[type=checkbox]")
    .removeAttr("checked");

  // add checked when label clicked
  labelSelected.find("input[type=checkbox]").attr("checked","checked")
    .parent().addClass("checked");

  // add rankChecked Class
  labelSelected.addClass("rankChecked")
    .removeAttr("style")
    .prevUntil()
    .removeAttr("style").addClass("rankChecked")

});

});

jQueryrankInput = jQuery("#rankInput");
function checkRank(rank) {
    jQueryrankInput.attr("value", rank);
}

jQuery(function() {
    var pathArray = window.location.pathname.split( '/' );
    jQuery('.menumatieres a[href$="/' + pathArray[pathArray.length-1] + '"]').addClass('active');
var urlClasse = "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/programme/"+pathArray[pathArray.length-3];
var urlMatiere = "https://tp.iha.unistra.fr/projets/dweb02/laravel/monpetitcartable/public/programme/"+pathArray[pathArray.length-3]+"/"+pathArray[pathArray.length-2];
    jQuery('#breadcrumb-classe > a').replaceWith('<a href=" '+urlClasse+'">'+pathArray[pathArray.length-3]+'</a>');  
    jQuery('#breadcrumb-matiere > a').replaceWith('<a href="'+urlMatiere+'">'+pathArray[pathArray.length-2]+'</a>');  
});