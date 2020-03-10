/**
* Theme cookies
* 
*/
jQuery(document).ready(function(){    
    var cookieName = 'hcc';
    var cookieOptions = {expires: 7, path: '/'};
    
    $("#" + $.cookie(cookieName)).addClass("selected");
    
    $('section').each(function(){
        let themeClass = $.cookie(cookieName);
        if( $(this).hasClass( themeClass ) ){
            return false;
        }
        else{
            if( $.cookie(cookieName) === 'dark-theme'){
                $(this).removeClass('light-theme').addClass('dark-theme');
            }
            else if( $.cookie(cookieName) === 'light-theme' ){
                $(this).removeClass('dark-theme').addClass('light-theme');
            }
            else{
                return false;
            }
        }
    });
    
    $(".switcher").on('click', function(e){
        $("#" + $.cookie(cookieName)).removeClass("selected");
        $.cookie(cookieName, $(this).attr("data-theme"), cookieOptions);
        $("#" + $.cookie(cookieName)).addClass("selected");
    });
});