$(document).ready(function(){
  var contact = function(){
    return{
      successDialog: function(){
        $('.contact-dialog').modal('show');

        setTimeout(function(){
          $('.contact-dialog').modal('hide');
        }, 3000);
      },

      send: function(){
        var contactData = {
          name: $('#name').val(),
          email: $('#email').val(),
          phone: $('#phone').val(),
          msg: $('#msg').val()
        },
        url = $('.contact-form').attr('action');

        $.ajax({
          url: url,
          method: 'POST',
          data: contactData,
          success: function(){
            contact().successDialog()
          },
          error: function(){
            alert('Ошибка, попробуйте позже');
          }
        });
      },

      init: function(){
        $('.send-msg').click(function(e){
          e.preventDefault();

          contact().send();
        })
      }
    }
  };

  contact().init();
});