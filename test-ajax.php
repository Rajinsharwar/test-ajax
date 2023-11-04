<?php
/*
 * Plugin Name: Test AJAX call of post exerpt
 */

function custom_excerpt_length( $length ) {
	return 20; //Set the post exerpt lenth here.
}

add_filter( 'excerpt_length', 'custom_excerpt_length', 1667 );

function get_latest_published_post() {
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish', // Filter by published posts.
	);

	$latest_post = new WP_Query( $args );

	if ( $latest_post->have_posts() ) {
		while ( $latest_post->have_posts() ) {
			$latest_post->the_post();
			echo get_the_excerpt();
		}
		wp_reset_postdata();
	} else {
		echo 'No published posts found.';
	}

	die();
}

add_action( 'wp_ajax_nopriv_get_latest_post', 'get_latest_published_post' );
add_action( 'wp_ajax_get_latest_post', 'get_latest_published_post' );


function enqueue_custom_script() {
    wp_enqueue_script('custom-script', plugin_dir_url( __FILE__ ) . '/custom.js', array('jquery'), '', true);
    wp_localize_script('custom-script', 'wpApiSettings', array(
        'root' => esc_url_raw(rest_url()),
        'nonce' => wp_create_nonce('wp_rest'),
    ));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');