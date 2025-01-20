jQuery(function ( $ ) {

    $( 'form#profile-form' ).on('submit', function (e){
        e.preventDefault();

        $.post(
            simpleAuthAjax.ajax_url,
            $(this).serialize() + '&_wpnonce' + simpleAuthAjax.nonce,
            function(response){
                if(response.success){
                    $('#profile-update-message').html(response.data.message);
                }
            });
    })

});