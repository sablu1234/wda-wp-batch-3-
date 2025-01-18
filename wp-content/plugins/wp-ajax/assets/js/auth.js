jQuery(function($){

    $('form#profile-form').on('submit', function(e){
        e.preventDefault();

        var button = $(this).find('button[type="submit"]');
        button.attr('disabled', 'disabled')
        
        $.post(
            simpleAuthAjax.ajax_url, 
            $(this).serialize() + '&_wpnonce=' + simpleAuthAjax.nonce , 
            function(response){
                if(response.success){
                    $('#profile-update-message')
                        .html(response.data.message)
                        .removeClass('hidden');

                    setTimeout(function(){
                        $('#profile-update-message').addClass('hidden');
                    }, 4000);

                    button.removeAttr('disabled');

                }
            });
    })

    $('form#simple-auth-login-form').on('submit', function(e){
        e.preventDefault();

        var button = $(this).find('button[type="submit"]');
        button.attr('disabled', 'disabled')
        
        wp.ajax.post( 'simple-auth-login-form', $(this).serialize() )
        .done( function(response){
            console.log('success',response);
        } )
        .fail( function(error){
            console.log( 'failed', error );
        } );
    }); 
    
});