
(function($) {

	skel
		.breakpoints({
			xlarge: '(max-width: 1680px)',
			large: '(max-width: 1280px)',
			medium: '(max-width: 980px)',
			small: '(max-width: 736px)',
			xsmall: '(max-width: 480px)'
		});

	$(function() {

		var	$window = $(window),
			$body = $('body');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 100);
			});

		// Prioritize "important" elements on medium.
			skel.on('+medium -medium', function() {
				$.prioritize(
					'.important\\28 medium\\29',
					skel.breakpoint('medium').active
				);
			});

	});

	$("a.toscroll").on('click',function(e) {
	    var href = $(this).attr('href');
	    $('html, body').animate({
	        scrollTop: $(href).offset().top
	    }, 'slow');
	    return false;
	});

		/*
	* Displays the whole faq with news.
	*/
	$('#faq_see_more').click(function(e){
       $('#faq_list').removeClass('faq_list_min_height');
       $('#faq_see_less').removeClass('displayNope');
       $('#faq_see_more').addClass('displayNope');
	});

	/*
	* Shrinks the div with faq to default size.
	*/
	$('#faq_see_less').click(function(e){
       $('#faq_list').addClass('faq_list_min_height');
       $('#faq_see_more').removeClass('displayNope');
       $('#faq_see_less').addClass('displayNope');
	});

	/*
	* Displays the hidden target gallery.
	*/
	$('#gallery_see_more').click(function(e){
       $('#gallery-target-images').removeClass('displayNope');
       $('#gallery_see_more').addClass('displayNope');
	});

	/*
	* Displays the whole div with news.
	*/
	$('#news_see_more').click(function(e){
       $('#news_list').removeClass('news_list_min_height');
       $('#news_see_less').removeClass('displayNope');
       $('#news_see_more').addClass('displayNope');
	});

	/*
	* Shrinks the div with news to default size.
	*/
	$('#news_see_less').click(function(e){
       $('#news_list').addClass('news_list_min_height');
       $('#news_see_more').removeClass('displayNope');
       $('#news_see_less').addClass('displayNope');
	});

	// ***************** CONTACT FORM *********************

	/* Contact form. */
	var contactForm = $('#contactForm');
	/* Contact form message. */
	var contactFormMessages = $('#contactForm-messages');

	/*
	* Sends a contact form with ajax.
	* Response is success (green message) or failure (red message)
	*/
	$(contactForm).submit(function(e) {

		// Stop the browser from submitting the form.
		e.preventDefault();

		var translations = getTranslations($('#hiddenLangContact').val());

		// Serialize the form data.
		var formData = $(contactForm).serialize();
		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(contactForm).attr('action'),
			data: formData
		})
		.done(function(response) {
			$(contactFormMessages).removeClass('error');
			$(contactFormMessages).addClass('success-target');

			// Set the message text.
			$(contactFormMessages).text(translations["CONTACT_MESSAGE_SENT"]);

			// Clear the form.
			$('#contactFormName').val('');
			$('#contactFormEmail').val('');
			$('#contactFormMessage').val('');
		})
		.fail(function(jqXHR, textStatus, error) {
			$(contactFormMessages).removeClass('success-target');
			$(contactFormMessages).addClass('error');

			if (error !== '') {
				if (jqXHR.status == 404) {
					// better safe than sorry
					$(contactFormMessages).text(translations["CONTACT_404"]);
				}
				else if(jqXHR.status == 500) {
					// Failed to connect to mailserver
					$(contactFormMessages).text(translations["CONTACT_500"]);
				}
				else
					$(contactFormMessages).text(translations["ERROR_UNEXPECTED"] + error);

				var errorMessage = jqXHR.status + " - " + jqXHR.statusText + "\n" + jqXHR.responseText;
				console.log(errorMessage)
				logError(errorMessage);
			} else {
				$(contactFormMessages).text(translations["CONTACT_ERROR"]);
			}
		});

	});

	/*
	* Error/Success message will be cleared after a click on reset button.
	*/
	$( "#contactResetButton" ).click(function(){
		$(contactFormMessages).text('');
		$(contactFormMessages).removeClass('error');
		$(contactFormMessages).removeClass('success-target');
	});


	// ***************** IMAGE INPUT **********************

	/* Image upload form. */
	var uploadForm = $('#uploadForm');
	/* Image form message. */
	var imageFormMessages = $('#imageForm-messages');
	/* Image form message text - . */
	var imageFormMessagesText = $('#imageForm-messages-text');
	/* Feedback form. */
	var imageFormMessagesFeedback = $('#imageForm-messages-feedback');
	/* Input image. */
	var inputImage = $('#inputImage');
	/* Image preview. */
	var outputImage = $('#outputImage');
	/* Loader. */
	var loader = $('#loader');

	$('.custom-upload input[type=file]').change(function(){
    	$(this).next().find('input').val($(this).val());
	});

	$( "#inputImage" ).change(function(){
		var translations = getTranslations($('#hiddenLangUpload').val());
	    readURL(this, translations);
	});

	function readURL(input, translations) {

		var url = input.value;
		//alert(url);
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		//&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")
		//alert(ext);
	    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#outputImage').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	        $(outputImage).removeClass('hide');
			$(outputImage).addClass('reveal');
	    }
	    else {
	    	changeImageUploadMessage(translations["ERROR_PREVIEW"], false);
	    }

	}

	function changeImageUploadMessage(text, isSuccess) {
		if (isSuccess) {
			$(imageFormMessagesText).text(text);
			$(imageFormMessages).removeClass('error');
			/*$(imageFormMessages).addClass('success-target');*/
		} else {
			$(imageFormMessagesText).text(text);
			$(imageFormMessages).removeClass('success-target');
			$(imageFormMessages).removeClass('success-nontarget');
			$(imageFormMessages).addClass('error');
		}

		$(imageFormMessages).removeClass('displayNope');
	}

	function resetImageUploadMessage() {
		$(imageFormMessagesText).text('');
		$(imageFormMessages).removeClass('error');
		$(imageFormMessages).removeClass('success-target');
		$(imageFormMessages).removeClass('success-nontarget');
		$(imageFormMessages).addClass('displayNope');
		$(imageFormMessagesFeedback).addClass('displayNope');
	} 

	$( "#imageResetButton" ).click(function(){
		if($('#outputImage').attr('src') != '' ) {
			$('#outputImage').attr('src', '');
		}

		resetImageUploadMessage();

		$(loader).addClass('displayNope');
		$(outputImage).addClass('hide');
		$(outputImage).removeClass('reveal');
	});

	function logError(message) {
		$.post( "scripts/log.php", { 'message': message } );
	}


	function grabStatistics() {
		$.post( "scripts/statistics.php", { 'message': 'data' } );
	}

	/*
	* Validates extension of image.
	*/
	function validateExtension(url) {
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

		if (ext == "png" || ext == "jpeg" || ext == "jpg")
			return true;
		else
			return false;
	}

	/*
	* Validates size of image. Max size is 3MB.
	*/
	function validateFileSize(input) {
		var maxSize = 3145728;
		var size = input[0].files[0].size;

		if (size <= maxSize)
			return true;
		else
			return false;
	}

	/* ******************** Lang ******************** */
	function getTranslations(lang) {
		var translations = {};

		switch(lang) {
			case 'cz':
				translations = {
					NO_IMAGE: "Nebyl vybrán žádný soubor.",
					WRONG_IMAGE_SIZE: "Velikost souboru nesmí být větší než 3MB.",
					ERROR_404: "[404] Oops! Požadovaná stránka nebyla nalezena. Prosím, vraťte se později.",
					ERROR_UNEXPECTED: "Oops! Vyskytla se neočekávaná chyba: ",
					ERROR_SEND: "Oops! Při odesílání došlo k chybě.",
					ERROR_UPLOAD: "Soubor nemohl být odeslán.",
					ERROR_PREVIEW: "Náhled není k dispozici. Prosím, vyberte soubor je s příponami png, jpeg nebo jpg.",
					FEEDBACK: "Děkuji za zpětnou vazbu.",
					CONTACT_404: "[404] Oops! Požadovaná stránka nebyla nalezena a vaše zpráva nebyla odeslána. Prosím, zkuste odeslat svou zprávu později.",
					CONTACT_500: "[500] Oops! Došlo k chybě na serveru a vaše zpráva nebyla odeslána. Prosím, zkuste odeslat svou zprávu později.",
					CONTACT_ERROR: "Oops! Vyskytla se neočekávaná chyba a vaše zpráva nemohla být odeslána.",
					CONTACT_MESSAGE_SENT: "Vaše zpráva byla odeslána."
				};
				break;
			default:
				translations = {
					NO_IMAGE: "No image has been chosen.",
					WRONG_IMAGE_SIZE: "Image size must be less than 3MB.",
					ERROR_404: "[404] Oops! Requested page not found. Your image could not be sent. Please, try it again later.",
					ERROR_UNEXPECTED: "Oops! Unexpected error occured: ",
					ERROR_SEND: "Oops! An error occured and your image could not be sent.",
					ERROR_UPLOAD: "This file could not be uploaded.",
					ERROR_PREVIEW: "Preview is not available. Please upload png, jpeg, jpg files only.",
					FEEDBACK: "Thank you for your feedback.",
					CONTACT_404: "[404] Oops! Requested page not found. Your message could not be sent. Please, try it again later.",
					CONTACT_500: "[500] Oops! Server internal error occured. Your message could not be sent. Please, try it again later.",
					CONTACT_ERROR: "Oops! An error occured and your message could not be sent.",
					CONTACT_MESSAGE_SENT: "Your message was sent."
				};
		}

		return translations;
	}
	

	$(uploadForm).submit(function(e){
		// Stop the browser from submitting the form.
		e.preventDefault();
		var translations = getTranslations($('#hiddenLangUpload').val());

		// Serialize the form data.
		var formData = new FormData($(uploadForm).get(0)); // $(uploadForm).serialize();
		resetImageUploadMessage();

		var url = $( "#inputImage" ).val();

		if( url == "" ) {
			changeImageUploadMessage(translations["NO_IMAGE"], false);
			return false;
		}

		var isAllowedExtension = validateExtension(url);
		var isAllowedFileSize = validateFileSize(inputImage);

		if (isAllowedFileSize == false) {
			changeImageUploadMessage(translations["WRONG_IMAGE_SIZE"], false);
			return false;
		}

		if(isAllowedExtension && isAllowedFileSize) {
			/*  */
			grabStatistics();

			/* Run loading circle. */
			$(loader).removeClass('displayNope');

			$.ajax({
			type: 'POST',
			url: $(uploadForm).attr('action'),
			data: formData,
			cache: false,
    		processData: false,
    		contentType: false
		})
		.done(function(response) {
			$(imageFormMessages).removeClass('error');

			/* Different colors for target and nontarget response. */
			if (response.predicted_class == 1) {
				$(imageFormMessages).addClass('success-target');
			} else if (response.predicted_class == 0) {
				$(imageFormMessages).addClass('success-nontarget');
			} else {
				$(imageFormMessages).addClass('error');
			}

			
			$(imageFormMessagesText).text(response.message);
			$(pathInput).val(response.server_filepath);
			$(PclassInput).val(response.predicted_class);

			$(imageFormMessages).removeClass('displayNope');
			$(imageFormMessagesFeedback).removeClass('displayNope');

			$(loader).addClass('displayNope');
		})
		.fail(function(jqXHR, textStatus, error) {
			$(imageFormMessages).removeClass('success-target');
			$(imageFormMessages).removeClass('success-nontarget');
			$(imageFormMessages).addClass('error');

			// Set the message text.
			if (error !== '') {
				if (jqXHR.status == 404) {
					// Python script pdetect.py was not found on server.
					$(imageFormMessagesText).text(translations["ERROR_404"]);
				}
				else
					$(imageFormMessagesText).text(translations["ERROR_UNEXPECTED"] + error);

				var errorMessage = jqXHR.status + " - " + jqXHR.statusText + "\n" + jqXHR.responseText;
				console.log(errorMessage)
				logError(errorMessage);
			} else {
				$(imageFormMessagesText).text(translations["ERROR_SEND"]);
			}

			$(imageFormMessages).removeClass('displayNope');
			$(loader).addClass('displayNope');
		});

		}
		else {
			changeImageUploadMessage(translations["ERROR_UPLOAD"], false);
			return false;
		} 

	});

	// ***************** FEEDBACK *************************
	/* Server path to input image. */
	var pathInput = $('#path-imageForm-messages-feedback');
	/* Class predicted by DNN model. */
	var PclassInput = $('#P-class-imageForm-messages-feedback');
	/* Yes button. */
	var yesButton = $('#imageForm-messages-button-yes');
	/* No button. */
	var noButton = $('#imageForm-messages-button-no');

	/*
	* The class predicted by DNN is correct.
	*/
	$(yesButton).click(function(e){
		e.preventDefault();
		var pathInputValue = $(pathInput).val();
		var PclassInputValue = $(PclassInput).val();
		var translations = getTranslations($('#hiddenLangUpload').val());

        $.ajax({
        	type: "POST",
            url: "scripts/feedbackProcessing.php",
            data: {'feedback': 1, 'path': pathInputValue, 'Pclass': PclassInputValue},
            success:function(result){
            	$(imageFormMessagesText).text(translations["FEEDBACK"]);
            	$(imageFormMessagesFeedback).addClass('displayNope');
            },
        	error:function(jqXHR, textStatus, error)
            {
  				var errorMessage = jqXHR.status + " - " + jqXHR.statusText + "\n" + jqXHR.responseText + "\n" + error;
				console.log(errorMessage)
				logError(errorMessage);
           }
       });
	});

	/*
	* The class predicted by DNN is incorrect.
	*/
	$(noButton).click(function(e){
		e.preventDefault();
		var pathInputValue = $(pathInput).val();
		var PclassInputValue = $(PclassInput).val();
		var translations = getTranslations($('#hiddenLangUpload').val());

		$.ajax({
        	type: "POST",
            url: "scripts/feedbackProcessing.php",
            data: {'feedback': 0, 'path': pathInputValue, 'Pclass': PclassInputValue},
            success:function(result){
            	$(imageFormMessagesText).text(translations["FEEDBACK"]);
            	$(imageFormMessagesFeedback).addClass('displayNope');
            },
        	error:function(jqXHR, textStatus, error)
            {
  				var errorMessage = jqXHR.status + " - " + jqXHR.statusText + "\n" + jqXHR.responseText + "\n" + error;
				console.log(errorMessage)
				logError(errorMessage);
           }
       });
	});

})(jQuery);