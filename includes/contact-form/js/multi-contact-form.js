jQuery(document).ready(function() {

	var messageDelay = 3000;

	jQuery("#RealEstate_sendMessage").click(function(evt) {

		evt.preventDefault();

		var RealEstate_contactForm = jQuery(this);

        var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

    	var uemail = jQuery('#RealEstate_senderEmail').val();

		if (!jQuery('#RealEstate_senderName').val() || !jQuery('#RealEstate_senderEmail').val() || !jQuery('#RealEstate_sendermessage').val()) {

            jQuery('#RealEstate_incompleteMessage').fadeIn().delay(messageDelay).fadeOut();

            RealEstate_contactForm.fadeOut().delay(messageDelay).fadeIn();

			// jQuery('#RealEstate_senderName').css('border', '1px solid red');

            return false;

    	} 

        else if(!re.test(uemail))

        {

              jQuery('#RealEstate_email_error').fadeIn().delay(messageDelay).fadeOut();

              return false;

        }

  		var uname = jQuery('#RealEstate_senderName').val();

        var umessage = jQuery('#RealEstate_sendermessage').val();

        if(!onlyalpha (uname))

        {

           jQuery('#RealEstate_name_error').fadeIn().delay(messageDelay).fadeOut();

           return false;     

        }

        if( ! alphanumeric(umessage) )

        {

           jQuery('#RealEstate_message_error').fadeIn().delay(messageDelay).fadeOut();

           return false; 

        }

        //else {

			jQuery('#RealEstate_sendingMessage').fadeIn();

			RealEstate_contactForm.fadeOut();

            var nonce = jQuery('#_wpnonce').val();

            form_content = jQuery('#RealEstate_contactForm').serialize();

              jQuery.ajax({

                type: "POST",

				url: ajaxformurl,

				data: form_content + '&action=realestate_process_form' + '&security=' + _wpnonce,

				    timeout: 20000,

                    error: function(jqXHR, textStatus, errorThrown) {

                      // alert('errorThrown');

                  		jQuery('#RealEstate_sendingMessage').hide();

                        RealEstate_contactForm.fadeIn();

                        alert('Fail to Connect with Data Base (9).\nPlease, try again later.');

                    }, 

                success: submitFinished

			});          

		// }

		return false;

	});

	jQuery(init_RealEstate_form);

	function init_RealEstate_form() {

		jQuery('#RealEstate_contactForm').hide(); //.submit( submitForm ).addClass( 'RealEstate_positioned' );

		jQuery('#RealEstate_sendingMessage').hide();

		jQuery('#RealEstate_successMessage').hide();

		jQuery('#RealEstate_failureMessage').hide();

		jQuery('#RealEstate_incompleteMessage').hide();

		jQuery("#RealEstate_cform").click(function() {

			jQuery('#RealEstate_cform').hide();

			jQuery('#RealEstate_contactForm').addClass('RealEstate_positioned');

			jQuery('#RealEstate_contactForm').css('opacity', '1');

			jQuery('#RealEstate_contactForm').fadeIn('slow', function() {

				jQuery('#RealEstate_senderName').focus();

			})

			return false;

		});

		// When the "Cancel" button is clicked, close the form

		jQuery('#RealEstate_cancel').click(function() {

			jQuery('#RealEstate_contactForm').fadeOut();

			jQuery('#content2').fadeTo('slow', 1);

            jQuery("#RealEstate_cform").fadeIn()

		});

		// When the "Escape" key is pressed, close the form

		jQuery('#RealEstate_contactForm').keydown(function(event) {

			if (event.which == 27) {

				jQuery('#RealEstate_contactForm').fadeOut();

				jQuery('#content2').fadeTo('slow', 1);

                jQuery("#RealEstate_cform").fadeIn()

			}

		});

	}

	function submitFinished(response) {

		response = jQuery.trim(response);

		jQuery('#RealEstate_sendingMessage').fadeOut();

		if (response == "success") {

			jQuery('#RealEstate_successMessage').fadeIn().delay(messageDelay).fadeOut();

			jQuery('#RealEstate_senderName').val("");

			jQuery('#RealEstate_senderEmail').val("");

			jQuery('#RealEstate_sendermessage').val("");

			jQuery('#content2').delay(messageDelay + 1000).fadeTo('slow', 1);

			jQuery('#RealEstate_contactForm').fadeOut();

            jQuery("#RealEstate_cform").fadeIn()

		} else {

			jQuery('#RealEstate_failureMessage').fadeIn().delay(messageDelay).fadeOut();

			jQuery('#RealEstate_contactForm').delay(messageDelay + 1000).fadeIn();

		}

	}

    function alphanumeric(inputtext)

    {

         if( /[^a-zA-Z0-9]/.test( inputtext ) ) {

           return false;

         }

        return true;

    }

    function onlyalpha(inputtext)

    {

     if( /[^a-zA-Z]/.test( inputtext ) ) {

       return false;

     }

      return true;

    }

}); // end jQuery ready