try{
    window.onload = function(){
        var nav = document.getElementById("customlinkdiv");
        if( nav ){
            var message = '<div class="customlink-message" style="padding-top: 10px;"><div>' + hcc_nav_params.message + '</div></div>';
            nav.innerHTML+= message;    
        }  
    }
}
catch(e){
    window.onload = function(){
        return false;
    }
}