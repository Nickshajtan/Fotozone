jQuery( document ).ready(function($) {
    sendForm();
});

function sendForm(){
    var form = $(document).find('form.custom-form');
    form.each( function(){
        if( typeof wpcf7 ==="undefined" ){
            customFormValidation(); // Enable custom validation
            bootstrapValidation();  // Enable bootstrap 4 validation
            sendingForm( $(this) );
        }      
    });
}

function sendingForm( form ){
    form.on('submit', function(e){
                e.preventDefault();
                e.stopPropagation();
                bootstrapValidation();
                customFormValidation(); 
                //jQueryFormValidation();
                if ( form.find('[required]').filter(function(){return $(this).val().length == 0;}).length > 0 ){ 
                    form.find('input').addClass('validate-show');
                    return false;
                } 
                let $preloader = $('.loaderArea');
                let $loader    = $preloader.find('.loader');
                let $data      = $(this).serializeArray(); 
                let $input     = $(this).find('input');
                let $textarea  = $(this).find('textarea');
                let $group     = $(this).find('.validation-group');
        
                $.ajax({
                      type: "POST",
                      url: ajaxurl,
                      data: {
                            action : 'hcc_ajax',
                            data : $data,
                      },
                      error: (function() {
                          try{
                            let Erform = $('.modal-error');
                            Erform.find('.modal-header').text(error_header);
                            Erform.find('.modal-body').text(error_body);
                            hideFeedBackInner();
                            showForm(form);     
                          }
                          catch(e){
                              console.log('Error on form sending');
                          }
                      }),
                      beforeSend: (function (){
                          $loader.fadeIn();
                          $preloader.fadeIn('slow');
                      }),
                      success: (function ( result ){
                          
                          if( result ){
                              var data = JSON.parse(result);
                              console.log(data);
                              if (data.error) {
                                    var errors = "";
                                    for (var error in data.errors) {
                                        errors += '<span class="er-mes">' + data.errors[error] + '</span><br/>';
                                    }  
                                    let Erform = $('.modal-error');
                                    Erform.find('.modal-header').text(error_header);
                                    Erform.find('.modal-body').html('<div>' + errors + '</div>');
                                    hideFeedBackInner();
                                    hideThisForm($('.modal-form'));
                                    showForm(form);
                              }
                              else{
                                  formSuccess();
                              }
                          }
                          else{
                              formSuccess();
                          }
                          
                          function formSuccess(){
                              if( !cfThankYou ){
                                  try{
                                      let Erform = $('.modal-error');
                                      Erform.find('.modal-header').text(success_header);
                                      Erform.find('.modal-body').text(success_body);
                                      hideFeedBackInner();
                                      hideThisForm($('.modal-form'));
                                      showForm(form);     
                                  }
                                  catch(e){
                                      console.log('Error with success modal form');
                                  }
                              }   
                              else if( home_url ){
                                  window.location.href = home_url + cfThankYou;
                              }
                          }
                      }),
                      complete: (function (){
                          $loader.fadeOut();
                          $preloader.delay(450).fadeOut('slow');
                      })
                }).done(function (data) {
                     form.removeClass('validated-success validated-unsuccess was-validated ');
                     $group.removeClass('validated-invalid validated-valid validated-warning group-was-validated');
                     $group.find('.form-element-validation').removeClass('element-was-validated');
                     $input.not('[type=submit]').val('');
                     $textarea.val('');
                });
            
                return false;
            });
}