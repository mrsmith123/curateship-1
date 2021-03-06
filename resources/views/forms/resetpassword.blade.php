<p class="cd-signin-modal__message">
  Lost your password? Please enter your email address. You will
  receive a link to create a new password.
</p>

<form action="{{ route('password.email') }}" method="POST" class="cd-signin-modal__form" id="reset-password-form">@csrf
  <div class="newsletter-card__feedback newsletter-card__feedback--success margin-top-sm" role="alert"> <!-- /.newsletter-card__feedback--is-visible -->
    Success!
  </div><!-- /.newsletter-card__feedback -->
  <p class="cd-signin-modal__fieldset">
    <label
      class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace"
      for="reset-email"
      >E-mail</label
    >
    <input
      class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border"
      id="reset-email"
      name="email"
      type="email"
      placeholder="E-mail"
    />
    <span class="cd-signin-modal__error">Error message here!</span>
  </p>

  <p class="cd-signin-modal__fieldset">
    <input
      class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding"
      type="submit"
      value="Reset password"
    />
  </p>
</form>

<script>
  (function(){
    // reset password form
    $(document).on('submit', '#reset-password-form', function(e){
      e.preventDefault();
      var $this = $(this);
      var url = $this.attr('action');
      var method = $this.attr('method');

      var email = $('#reset-email').val();

      var $feedback = $this.find('.newsletter-card__feedback');

      $.ajax({
        url: url,
        type: method,
        dataType: 'JSON',
        data: $this.serialize(),
        success:function(response){
          // console.log(response);

          if (response.status === 'success') {
            $feedback.removeClass('newsletter-card__feedback--error').addClass('newsletter-card__feedback--success newsletter-card__feedback--is-visible').html('<strong>Success!</strong> ' + response.message);

            // reset
            $this[0].reset();
            $('.cd-signin-modal__error').removeClass('cd-signin-modal__error--is-visible');
            $('input').removeClass('cd-signin-modal__input--has-error');

          }else{
            $feedback.removeClass('newsletter-card__feedback--success').addClass('newsletter-card__feedback--error newsletter-card__feedback--is-visible').html(response.message);

            $('.cd-signin-modal__error').removeClass('cd-signin-modal__error--is-visible');
            $('input').removeClass('cd-signin-modal__input--has-error');
          }
        },
        error: function(response){
          console.log(response.responseText);
          var jsonResponse = response.responseJSON;
          var errors = jsonResponse.errors;
          var errorsHTML = '';

          $('.cd-signin-modal__error').removeClass('cd-signin-modal__error--is-visible');
          $('input').removeClass('cd-signin-modal__input--has-error');

          $.each( errors, function( key, value ) {
            errorsHTML += value[0] + '</br>';

            $('#reset-'+key).addClass('cd-signin-modal__input--has-error');

            $('#reset-'+key+' + .cd-signin-modal__error').addClass('cd-signin-modal__error--is-visible').html(value[0]);

          });

        }
        });
    });
  })();
</script>