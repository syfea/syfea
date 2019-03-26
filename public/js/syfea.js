$(document).on('submit', 'form', function(e){
    // il est impératif de commencer avec cette méthode qui va empêcher le navigateur d'envoyer le formulaire lui-même
    e.preventDefault();
    $form = $(e.target);

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
           jQuery("#fh5co-consult").html(data);
        },
        error: function(jqXHR, status, error) {
            $submitButton.html(button.data('label'));
            $submitButton.prop('disabled', false);
        }
    });
});