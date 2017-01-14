<?php
/**
 * This file contains all the shortcode register functionality.
 * All the functions are pluggable which means that they can be replaced in a child theme.
 *
 * @author Pexeto
 */

/* ----------------------------------------------------------------------------*
 * SERVICES
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'pexeto_show_services' ) ) {
	/**
	 * Generates the services boxes HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the boxes
	 */
	function pexeto_show_services( $atts, $content = null ) {
		extract( shortcode_atts( array(
					'title' => '',
					'desc' => '',
					'set' => 'default',
					'columns' => '3'
				), $atts ) );

		$columns = intval($columns);
		if ( !empty( $title ) || !empty( $desc ) ) {
			$columns+=1;
		}

		$title_box_included = false;

		$html='<div class="services-wrapper cols-wrapper cols-'.($columns).'">';

		if ( !empty( $title ) || !empty( $desc ) ) {
			$title_box_included = true;

			$html.='<div class="services-title-box col">';
			if ( !empty( $title ) ) $html.='<h1>'.$title.'</h1>';
			if ( !empty( $desc ) ) $html.='<p>'.$desc.'</p>';
			$html.='</div>';
		}

		//get the services boxes from this set
		$boxes_data = PexetoCustomPageHelper::get_instance_data( PEXETO_SERVICES_POSTTYPE, $set );

		$boxes = $boxes_data['posts'];

		$data_keys=array( 'box_title', 'box_image', 'box_desc', 'box_link' );
		$columns = intval( $columns );

		for ( $i=0; $i<sizeof( $boxes ); $i+=$columns ) {
			$max_index = min( $i+$columns, sizeof( $boxes ) );
			$add_class = ( $i==0 && $title_box_included==true ) ? ' small-wrapper':'';
			// $html.='<div class="services-boxes-wrapper columns-'.$columns.' '.$add_class.'">';
			for ( $j=$i; $j<$max_index; $j++ ) {

				//print the single box
				$box_data = pexeto_get_multi_meta_values( $boxes[$j]->ID, $data_keys, PEXETO_CUSTOM_PREFIX );
				$open_link = empty( $box_data['box_link'] )?'':'<a href="'.$box_data['box_link'].'" />';
				$close_link = empty( $box_data['box_link'] )?'':'</a>';
				$add_class = $j==$max_index-1?' nomargin':'';

				$html.='<div class="services-box col'.$add_class.'">';


				if ( !empty( $box_data['box_image'] ) ) {
					$html.=$open_link;
					$html.='<img src="'.$box_data['box_image'].'" />';
					$html.=$close_link;
				}

				$html.=$open_link;
				$html.='<h3>'.$box_data['box_title'].'</h3>';
				$html.=$close_link;

				if ( !empty( $box_data['box_desc'] ) )
					$html.='<p>'.$box_data['box_desc'].'</p>';

				$html.='</div>';
			}
			// $html.='</div>';
		}

		$html.='<div class="clear"></div></div>';

		return $html;
	}
}
add_shortcode( 'services', 'pexeto_show_services' );


/* ----------------------------------------------------------------------------*
 * CAROUSEL
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'pexeto_show_carousel' ) ) {

	/**
	 * Generates the portfolio carousel HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the carousel
	 */
	function pexeto_show_carousel( $atts, $content = null ) {
		extract( shortcode_atts( array(
					'title' => '',
					'cat' => '-1',
					'orderby' => 'date',
					'order' => 'DESC',
					'maxnum' => '-1'
				), $atts ) );
		$html='';

		$args = array(
			'post_type'=>PEXETO_PORTFOLIO_POST_TYPE,
			'orderby'=>$orderby,
			'order'=>$order,
			'posts_per_page'=>$maxnum
		);

		if ( $cat!='-1' ) {
			$args[PEXETO_PORTFOLIO_TAXONOMY]=get_term_by( 'id', $cat, PEXETO_PORTFOLIO_TAXONOMY )->slug;
		}


		$car_posts = get_posts( $args );

		$html = pexeto_build_portfolio_carousel_html( $car_posts, $title );

		return $html;
	}
}
add_shortcode( 'carousel', 'pexeto_show_carousel' );

/* ----------------------------------------------------------------------------*
 * TABS
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'pexeto_show_tabs' ) ) {

	/**
	 * Generates the tabs element HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the tabs element
	 */
	function pexeto_show_tabs( $atts, $content = null ) {
		extract( shortcode_atts( array(
					'titles' => '',
					'width' => 'medium'
				), $atts ) );
		$titlearr=explode( ',', $titles );
		$html='<div class="tabs-container"><ul class="tabs ">';
		if ( $width=='small' ) {
			$wclass='w1';
		}elseif ( $width=='big' ) {
			$wclass='w3';
		}else {
			$wclass='w2';
		}
		foreach ( $titlearr as $title ) {
			$html.='<li class="'.$wclass.'"><a href="#">'.$title.'</a></li>';
		}
		$html.='</ul><div class="panes">'.do_shortcode( $content ).'</div></div>';
		return $html;
	}
}
add_shortcode( 'tabs', 'pexeto_show_tabs' );


if ( !function_exists( 'pexeto_show_pane' ) ) {

	/**
	 * Generates the single tab pane HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the single tab pane
	 */
	function pexeto_show_pane( $atts, $content = null ) {
		return '<div>'.do_shortcode( $content ).'</div>';
	}
}
add_shortcode( 'pane', 'pexeto_show_pane' );


if ( !function_exists( 'pexeto_show_accordion' ) ) {

	/**
	 * Generates the accordion element HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the accordion element
	 */
	function pexeto_show_accordion( $atts, $content = null ) {
		return '<div class="accordion-container">'.do_shortcode( $content ).'</div>';
	}
}
add_shortcode( 'accordion', 'pexeto_show_accordion' );

if ( !function_exists( 'pexeto_show_apane' ) ) {

	/**
	 * Generates the accordion pane HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the accordion pane
	 */
	function pexeto_show_apane( $atts, $content = null ) {
		extract( shortcode_atts( array(
					'title' => ''
				), $atts ) );
		return '<div class="accordion-title">'.$title
			.'<span class="ac-indicator"></span></div><div class="pane">'
			.do_shortcode( $content ).'</div>';
	}
}
add_shortcode( 'apane', 'pexeto_show_apane' );

/* ----------------------------------------------------------------------------*
 * TESTIMONIALS
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'pexeto_show_testim' ) ) {

	/**
	 * Generates the testimonial element HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the testimonial element
	 */
	function pexeto_show_testim( $atts, $content = null ) {
		extract( shortcode_atts( array(
					"name" => '',
					"img" =>'',
					"org" =>'',
					"link" =>'',
					"occup" =>''
				), $atts ) );

		$addClass=$img?'':' no-image';
		$testim='<div class="testimonial-container'.$addClass.'"><h2>'.$name.'</h2><span class="testimonials-details">'.$occup;
		if ( $org ) {
			$testim.=' / ';
			if ( $link ) $testim.='<a href="'.$link.'">';
			$testim.=$org;
			if ( $link ) $testim.='</a>';
		}
		$testim.='</span><div class="double-line"></div>';
		if ( $img ) $testim.='<img class="img-frame testimonial-img" src="'.$img.'" alt="" />';
		$testim.='<blockquote><p>'.do_shortcode( $content ).'</p></blockquote><div class="clear"></div></div>';
		return $testim;
	}
}
add_shortcode( 'pextestim', 'pexeto_show_testim' );


/* ----------------------------------------------------------------------------*
 * CONTACT FORM
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'pexeto_contact_form' ) ) {

	/**
	 * Generates the contact form HTML from the shortcode
	 *
	 * @param array   $atts    the shortcode attributes
	 * @param string  $content
	 * @return string          the generated HTML code of the contact form
	 */
	function pexeto_contact_form() {
		$html='<div class="widget-contact-form">
			<form action="'.get_template_directory_uri().'/includes/send-email.php" method="post" 
			id="submit-form" class="pexeto-contact-form">
			<div class="error-box error-message"></div>
			<div class="info-box sent-message"></div>
			<input type="text" name="name" class="required placeholder" id="name_text_box" 
			placeholder="'.pexeto_text( 'name_text' ).'" />
			<input type="text" name="email" class="required placeholder email" 
			id="email_text_box" placeholder="'.pexeto_text( 'your_email_text' ).'" />
			<textarea name="question" rows="" cols="" class="required"
			id="question_text_area"></textarea>
			<input type="hidden" name="widget" value="true" />

			<a class="button send-button"><span>'.pexeto_text( 'send_text' ).'</span></a>
			<div class="contact-loader"></div><div class="check"></div>

			</form><div class="clear"></div></div>';
		return $html;
	}
}

add_shortcode( 'contactform', 'pexeto_contact_form' );
