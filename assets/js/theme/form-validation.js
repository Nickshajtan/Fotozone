jQuery( document ).ready(function($) {
    customValid(); //Custom validation for tel & text inputs
    //bootstrapValidation();
    //customFormValidation(); 
    //jQueryFormValidation();
    FormOnFocus();
});

function FormOnFocus(){
     $('form').each(function(){
       let $this = $(this);
       $this.find('*').on('focus', function(){
          $this.addClass('on-focus');
       });
       $(document).mouseup(function (e){
            if (!$this.is(e.target) && $this.has(e.target).length === 0) {
			     $this.removeClass('on-focus');
                 $this.removeClass('validated-success validated-unsuccess was-validated ');
                 $this.find('.validation-group').removeClass('validated-invalid validated-valid validated-warning group-was-validated');
                 $this.find('.validation-group').find('.form-element-validation').removeClass('element-was-validated');
		    }
       });
    });
}

function customValid(){
    $('input[type=tel]').each(function(){
       $(this).attr('onkeypress', 'validateTel(event)');
    });
    $('input[type=text]').each(function(){
       $(this).attr('onkeypress', 'validateText(event)');
    });
}

//Custom validate tel
function validateTel(evt) {
      if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
      }
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode( key );
      var regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
}

//Custom validate text
function validateText(evt) {
      if ( event.keyCode == 32 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
      }
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode( key );
      var regex = /^[а-яa-z]+$/i;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
}

function bootstrapValidation(){
    (function() {
          'use strict';
          window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === true) {
                     form.classList.add('validated-success');
                }
                if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();
                     form.classList.add('validated-unsuccess');
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
}

function customFormValidation(){
    (function() {
          'use strict';
          window.addEventListener('load', function() {
            var formChildElements = document.getElementsByClassName('form-element-validation');
            var validation = Array.prototype.filter.call(formChildElements, function(element) {
              element.addEventListener('input', function(event) {
                var parentElement = element.closest('.validation-group');
                parentElement.classList.remove('validated-invalid');
                parentElement.classList.remove('validated-valid');
                parentElement.classList.remove('validated-warning');
                if (element.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                      parentElement.classList.add('validated-invalid');
                }
                else{
                      if( element.getAttribute('required') || element.value ){
                        parentElement.classList.add('validated-valid');
                      }
                      else{
                        parentElement.classList.add('validated-warning');
                     }
                }
                parentElement.classList.add('group-was-validated');
                element.classList.add('element-was-validated');
              }, false);
            });
            var forms = document.getElementsByClassName('needs-validation');
            var sendValidation =  Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    var groupElement = form.querySelector('.validation-group');
                    groupElement.classList.remove('validated-invalid');
                    groupElement.classList.remove('validated-valid');
                    groupElement.classList.remove('validated-warning');
                    groupElement.classList.remove('group-was-validated');
                    var childElement = groupElement.querySelector('.form-element-validation');
                    childElement.classList.remove('element-was-validated');
                });
            });
          }, false);
    })();
}

function jQueryFormValidation(){
	$('form.custom-form').each( function() {
        try{
            $(this).validate({
                errorElement : 'div',
                rules: {
                    name: {
                        required : true,
                        minlength: 3,
                        maxlength: 20,
                    },
                    email : {
                        required : true,
                        email: true,
                    },
                    phone: {
                        required : true,
                        minlength: 4,
                        maxlength: 20,
                        digits: true
                    },
                },
                // Specify validation error messages
                messages: {
                    name: {
                        required: "Введите ваше имя.",
                        maxlength: jQuery.validator.format("Введите не более {0} символов."),
                        minlength: jQuery.validator.format("Введите не менее {0} символов."),
                    },
                    email: {
                        required: "Введите ваш email.",
                        email: "Введите правильный email.",
                    },
                    phone: {
                        required: "Введите ваш телефон.",
                        digits: "Введите только цифры.",
                        maxlength: jQuery.validator.format("Введите не более {0} символов."),
                        minlength: jQuery.validator.format("Введите не менее {0} символов."),
                    },
                },
                submitHandler: function(form) {
                    event.preventDefault();
                    form.submit();
                }
            });
        }
		catch(e){
            console.log('Problem with jQuery Validate plugin');
        }
	});
}