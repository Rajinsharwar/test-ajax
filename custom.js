jQuery.ajax( {
    url: '/wp-admin/admin-ajax.php', // Assuming your WordPress installation is in the web root of your server.
    method: 'POST',
    data: {
        action: 'get_latest_post'
    }
} ).done( function ( response ) {
    console.log('From AJAX: ' + response);
} );

jQuery.ajax( {
    url: wpApiSettings.root + 'wp/v2/posts',
    method: 'GET',
    beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
    }
} ).done( function ( response ) {
    console.log( 'From Rest API: ' + response[0].excerpt.rendered );
} );