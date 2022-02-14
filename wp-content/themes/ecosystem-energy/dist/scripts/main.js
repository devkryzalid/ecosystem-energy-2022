/**
* Main Js file, call on each page of the site 
*/

jQuery(document).ready(function( $ ) {

   /**
    * 
    * Script JsBlockLink utils
    * Search href link on a html block with class '.jsBlockLink' (Better for SEO 🤓)
    * 
    */
   $(".jsBlockLink").click(function(e) {
    var $link = $(this).find("a").not(".jsIgnoreBlockLink");
    if( $link.length ) {
        if( ($link.attr("target") && $link.attr("target") === "_blank") ||
        e.ctrlKey ||
        e.button === 1) {
            window.open( $link.attr("href") );
        }
        else if (e.button === 0) {
            document.location.href = $link.attr("href");
        }
    }
    return false;
});

});