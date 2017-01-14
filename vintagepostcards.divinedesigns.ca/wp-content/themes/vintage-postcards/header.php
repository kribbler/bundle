<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

do_action( 'genesis_doctype' );
do_action( 'genesis_title' );
do_action( 'genesis_meta' );

wp_head(); //* we need this for plugins

genesis_markup( array(
	'html5'   => '<body %s><div class="container-fluid">',
	'xhtml'   => sprintf( '<body class="%s"><div>', implode( ' ', get_body_class() ) ),
	'context' => 'body',
) );

do_action( 'genesis_before' );

function genesis_child_header_markup_open() {

	echo("<div class='row'><div class='col-lg-12'><header>");
}

function genesis_child_header_markup_close() {

	echo("</header></div></div>");
}

function genesis_child_do_header() {
	echo('<div class="col-xs-6">');
	echo('<div class="postcard-logo">');
	echo('<img src="' . get_stylesheet_directory_uri() . '/images/head.png" alt="Sepia tone image of an Ontario, Canada native person along side the site title, which is Vintage Postcards.">');	
	echo('</div>');
	echo('</div>');
}

function genesis_child_do_header_right() {
	echo('<div class="col-xs-2 header-right">');
	dynamic_sidebar('header-right');
	echo('</div>');
}

function genesis_child_do_header_search() {
	echo('<div class="col-xs-4 header-search">');
	dynamic_sidebar('search');
	echo('</div>');
}

remove_action( 'genesis_header', 'genesis_header_markup_open',5 );
remove_action( 'genesis_header', 'genesis_do_header',10);
remove_action( 'genesis_header', 'genesis_header_markup_close',15);

add_action( 'genesis_header', 'genesis_child_header_markup_open', 5 );
add_action( 'genesis_header', 'genesis_child_do_header', 10);
add_action( 'genesis_header', 'genesis_child_do_header_search', 15);
add_action( 'genesis_header', 'genesis_child_do_header_right', 20);
add_action( 'genesis_header', 'genesis_child_header_markup_close', 25 );

do_action( 'genesis_before_header' );
do_action( 'genesis_header' );
do_action( 'genesis_after_header' );

genesis_markup( array(
	'html5'   => '<div class="row">',
	'xhtml'   => '<div class="row">',
	'context' => 'site-inner',
) );

include('sidebar-alt.inc.php');

genesis_structural_wrap( 'site-inner' );