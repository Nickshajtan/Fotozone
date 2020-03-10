jQuery( document ).ready(function($) {
    //modalForms();
});

function modalForms(){
    let href = window.location.href.toLowerCase();
    if( is_404_url !== 'true' && href.indexOf( cfThankYou.toLowerCase() ) === -1 ){
        let modalForm = $('.modal-form');
        //Out
        if ( $(window).width() > 1200 ) {
                    setTimeout( showFormOut, 500, modalForm );
        }
        setInterval(showFormOut, 59000, modalForm);
        //Once
        setTimeout(showForm, 60000, modalForm);    
    }
    
    //Esc
    $(document).keydown(function(eventObject){
                if (eventObject.which == 27){ 
                            hideForm(); 
                }
    });
    //click out form close
    $('.modal-wrapper').on('click', function(e){
            hideForm();  
    }).on('click', 'div', function(e) {
            e.stopPropagation();
    });
    //click on close icon
    $('.modal').find('.closer').on('click', function(){
            hideForm();
    });
}

function showForm(form){
    if( !$('.modal-error').hasClass('show-visible') && !$('form').hasClass('on-focus') && !$('.contact-button-wrap').hasClass('active') ){
        var header  = $('#masthead');
        if( !header.hasClass('opened') && !$('.contact-button-wrap').hasClass('active') ){
                form.addClass('show-visible');
                $('body').addClass('noscroll modal-open');
        }
    }
}

function showStronglyForm(form){
        var header  = $('#masthead');
        if( !header.hasClass('opened') ){
                $(form).addClass('show-visible');
                $('body').addClass('noscroll modal-open');
        }
}

function hideForm(){
    let $form      = $('.modal-form').find('form');
    let $input     = $form.find('input');
    let $textarea  = $form.find('textarea');
    let $group     = $form.find('.validation-group');
    $('.modal').removeClass('show-visible');
    $form.removeClass('validated-success validated-unsuccess was-validated ');
    $group.removeClass('validated-invalid validated-valid validated-warning group-was-validated');
    $group.find('.form-element-validation').removeClass('element-was-validated');
    $input.not('[type=submit]').val('');
    $textarea.val('');
    $('body').removeClass('noscroll modal-open');
    $('.overlay').removeClass('on');
    hideFeedBackInner();
}

function hideThisForm(form){
    let $form      = $(this).find('form');
    let $input     = $(this).find('input');
    let $textarea  = $(this).find('textarea');
    let $group     = $(this).find('.validation-group');
    form.removeClass('show-visible');
    $form.removeClass('validated-success validated-unsuccess was-validated ');
    $group.removeClass('validated-invalid validated-valid validated-warning group-was-validated');
    $group.find('.form-element-validation').removeClass('element-was-validated');
    $input.not('[type=submit]').val('');
    $textarea.val('');
    $('body').removeClass('noscroll modal-open');
    $('.overlay').removeClass('on');
    hideFeedBackInner();
}

function showFormOut(form){
        if( !$('.modal-error').hasClass('show-visible') && !$('.contact-button-wrap').hasClass('active') && !$('form').hasClass('on-focus') ){
            $(document).on('mouseleave', function(e){
                    if ( e.clientY < 0 ) {
                                    showForm(form);
                    }     
                    $(this).off('mouseleave');
            });
        }
}