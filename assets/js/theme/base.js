/**
*  Base theme js functions
*
*/

jQuery( document ).ready(function($) {
    //FontsLoading();
});

/*
* Include WP 5 lazy-loading for images
*
*/

document.addEventListener("DOMContentLoaded", setImageClass);
function setImageClass(){
    let img = document.querySelectorAll('img');
    img.forEach( (element) => {
        element.classList.add('lazy-loading');
        element.setAttribute('loading', 'lazy');
    });
}

/*
* Rules for fonts loading
* You can use this classes for fonts styling (CSS Font Rendering Controls)
*/

function FontsLoading(){
    try{
        let mainFont      = new FontFaceObserver('MuseoSansCyrl');
        let secondaryFont = new FontFaceObserver('ft40');
        let cursiveFont   = new FontFaceObserver('Qwigley');
        let helperFont    = new FontFaceObserver('Calama Regular');
        var html = document.documentElement;
        html.classList.add('fonts-loading');
        
        if (sessionStorage.mainFontLoaded && sessionStorage.secondaryFontLoaded) {
            html.classList.remove('fonts-loading');
            html.classList.add('fonts-loaded');
        }

        Promise.all([ /* Group here */ ]).then(function () { 
            console.log();
        });

        mainFont.load().then(function () {
            console.log();
            sessionStorage.mainFontLoaded = true;
        }).catch(function () {
            sessionStorage.mainFontLoaded = false;
        });
        secondaryFont.load().then(function () {
            console.log();
            sessionStorage.secondaryFontLoaded = true;
            html.classList.remove('fonts-loading');
            html.classList.add('fonts-loaded');
            helperFont.load().then(function () {
                console.log();
                sessionStorage.helperFontLoaded = true;
            }).catch(function () {
                sessionStorage.helperFontLoaded = false;
            });
            cursiveFont.load().then(function () {
                console.log();
                sessionStorage.cursiveFontLoaded = true;
            }).catch(function () {
                sessionStorage.cursiveFontLoaded = false;
            });
        }).catch(function () {
                sessionStorage.secondaryFontLoaded = false;
                html.classList.remove('fonts-loading');
                html.classList.add('fonts-failed');
        });
    }
    catch(e){
        console.log('Problem with JS fonts loading');
    }
}