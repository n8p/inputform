/**
 * Related functions and operations for suggestion box form.
 */
(function($) {
  var form = $('#suggestion-form');

  $(form).submit(function(event) {
    event.preventDefault();

    // Pass the generated CSRF token.
    $.ajaxSetup({
      data: {
        'csrftoken': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
        type: 'POST',
        url: 'includes/validate.php',
        dataType: 'json',
        data: {
          email: $('#email').val(),
          phrase: $('#phrase').val(),
        },
        success : function(response) {
          processResponse(response);
        },
        error: function (xhr, options, error) {
          // In real life applications, we'll want to
          // do some proper error handling here.
        }
    });
  });

  /**
   * Walks through the reponse object received from
   * the AJAX call.
   */
  function processResponse(response) {
    var errors = 0;

    Object.keys(response).forEach(function(key) {
      switch (key) {
        case 'errors':
          errors = processErrors(key, response[key], errors);
          break;

        case 'values':
          // Only display the content if there are no errors.
          if (errors === 0) {
            processContent(key, response[key]);
          }
          break;
      }
    });
  }

  /**
   * Processes errors returned by form AJAX call.
   */
  function processErrors(key, data, errors) {

    // Update the errors by adding the proper class and fill in
    // the specific error message.
    Object.keys(data).forEach(function(element) {
      if (data[element]) {
        $('#' + element).addClass('is-invalid');
        $('#' + element).next('.invalid-feedback').text(data[element]);
        errors++
      }
      else {
        $('#' + element).removeClass('is-invalid');
      }
    });

    return errors;
  }

  /**
   * Adds the submitted content below the form.
   */
  function processContent(key, data) {
    $('#suggestion-form')[0].reset();
    $('#response').empty();
    $('#response').append('<h2>Posted Messages</h2>');
    Object.keys(data).forEach(function(element) {
      $('#response').append('<p>' + data[element] + '</p>');
    })
  }
})(jQuery);
