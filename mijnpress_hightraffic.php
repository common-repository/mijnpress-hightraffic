<?php
/*
Plugin Name: MijnPress high traffic
Plugin URI: https://www.mijnpress.nl
Description: Plugin to create a (more) stable site when having lot's of traffic
Version: 2.0.0
Author: Ramon Fincken
Author URI: https://www.mijnpress.nl
*/
if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");


/**
* Comment cookies reduce
*/
add_filter( 'comment_cookie_lifetime', 'mijnpress_ht_comment_cookie_lifetime' );
function mijnpress_ht_comment_cookie_lifetime($lifetime) {
	return 5*MINUTE_IN_SECONDS;
}

/**
* Make it easier to cache / proxy cache css and js files
*/
/* ?ver= */
function remove_cssjs_ver( $src ) {
	if( strpos( $src, '?ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	if( strpos( $src, '?v=' ) ) {
		$src = remove_query_arg( 'v', $src );
	}
	if( strpos( $src, '?version=' ) ) {
		$src = remove_query_arg( 'version', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
/* ?ver= */


remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
add_filter( 'xmlrpc_enabled', '__return_false' );
