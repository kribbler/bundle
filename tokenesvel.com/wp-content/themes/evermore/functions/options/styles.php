<?php


/**
 * Load the patterns into arrays.
 */
$patterns=array();
$patterns[0]='none';
for ( $i=1; $i<=34; $i++ ) {
	$patterns[]='pattern'.$i.'.png';
}


$pexeto_styles_options=array( array(
		'name' => 'Style settings',
		'type' => 'title',
		'img' => 'icon-write'
	),

	array(
		'type' => 'open',
		'subtitles'=>array(
			array( 'id'=>'general', 'name'=>'General' ),
			array( 'id'=>'bg', 'name'=>'Background Options' ),
			array( 'id'=>'text', 'name'=>'Text Styles' ),
			array( 'id'=>'fonts', 'name'=>'Fonts' ),
			array( 'id'=>'add_styles', 'name'=>'Additional Styles' )
		)
	),

	/* ------------------------------------------------------------------------*
	 * GENERAL
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id' => 'general'
	),

	array(
		'name' => 'Predefined Background Colors',
		'id' => 'body_bg',
		'type' => 'stylecolor',
		'options' => array( '', 'f1f1ed','f2f0ea','c4c6bb','626262','373f48' ),
		'std' => '',
		'desc' => 'You can either select a predefined background color or pick 
			your custom color below. If the first option is selected, the background 
			color will be set as the default background of the skin selected.'
	),

	array(
		'name' => 'Custom Background Color',
		'id' => 'custom_body_bg',
		'type' => 'color',
		'desc' => 'You can select a custom background color for your theme. 
			This field has priority over the "Predefined Background Colors" field above. '
	),

	array(
		'name' => 'Predefined Elements Color',
		'id' => 'elements_color',
		'type' => 'stylecolor',
		'options' => array( '','7caa51','6f9344','00a569','2a7e6c','15b1ce','4090ba','257fb1','e15854','e64432','d14836','8764b6' ),
		'std' => '',
		'desc' => 'This is the color of the small detailed elements such as 
			buttons, selected menu item border, some links color etc.'
	),

	array(
		'name' => 'Custom Elements Color',
		'id' => 'custom_elements_color',
		'type' => 'color',
		'desc' => 'You can select a custom elements color for your theme. 
			This field has priority over the "Predefined elements colors" field above. '
	),

	array(
		'name' => 'Background Pattern',
		'id' => 'pattern',
		'type' => 'pattern',
		'options' => $patterns,
		'desc' => 'Here you can choose the pattern for the theme. There are 2 
			types of patterns - the first 17 patterns best suit light backgrounds, 
			the rest of them best suit darker backgrounds.'
	),

	array(
		'name' => 'Custom Background Pattern',
		'id' => 'custom_pattern',
		'type' => 'upload',
		'desc' => 'You can upload your custom background image here.'
	),

	array(
		'type' => 'close' ),



	/* ------------------------------------------------------------------------*
	 * BACKGROUND OPTIONS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'bg',
	),

	array(
		'name' => 'Content container background color',
		'id' => 'content_bg',
		'type' => 'color',
		'desc' => 'The background of the main content area.'
	),


	array(
		'name' => 'Secondary color',
		'id' => 'secondary_color',
		'type' => 'color',
		'desc' => 'This is the secondary content color, used in widgets 
			(tabs, accordion), hover in sidebar, comments section, etc.'
	),

	array(
		'name' => 'Lines and borders color',
		'id' => 'border_color',
		'type' => 'color'
	),

	array(
		'name' => 'Footer lines and borders color',
		'id' => 'footer_border_color',
		'type' => 'color'
	),


	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * TEXT STYLES
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id'=>'text',
	),

	array(
		'name' => 'Main body text color',
		'id' => 'body_color',
		'type' => 'color',
		'desc' => 'This setting will change the main content and sidebar text color.'
	),

	array(
		'name' => 'Headings color',
		'id' => 'heading_color',
		'type' => 'color'
	),

	array(
		'name' => 'Links color',
		'id' => 'link_color',
		'type' => 'color'
	),

	array(
		'name' => 'Footer text color',
		'id' => 'footer_text_color',
		'type' => 'color'
	),

	array(
		'name' => 'Footer links color',
		'id' => 'footer_link_color',
		'type' => 'color'
	),


	array(
		'type' => 'close' ),

	/* ------------------------------------------------------------------------*
	 * FONTS
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id' => 'fonts'
	),


	array(
		'type' => 'multioption',
		'id' => 'body_font',
		'name' => 'Body font',
		'desc' => 'You can add additional fonts in the Google API fonts section
		below',
		'fields' => array(
			array(
				'id' => 'family',
				'name' => 'Font Family',
				'type' => 'select',
				'options' => pexeto_get_font_options(),
				'std' => 'default' ),
			array(
				'id' => 'size',
				'name' => 'Font Size',
				'type' => 'text',
				'suffix' => 'px'
			),
		)
	),

	array(
		'type' => 'multioption',
		'id' => 'menu_font',
		'name' => 'Menu font',
		'desc' => 'You can add additional fonts in the Google API fonts section
		below',
		'fields' => array(
			array(
				'id' => 'family',
				'name' => 'Font Family',
				'type' => 'select',
				'options' => pexeto_get_font_options(),
				'std' => 'default' ),
			array(
				'id' => 'size',
				'name' => 'Font Size',
				'type' => 'text',
				'suffix' => 'px'
			),
		)
	),

	array(
		'type' => 'select',
		'id' => 'headings_font_family',
		'name' => 'Headings font family',
		'options' => pexeto_get_font_options(),
		'desc' => 'You can add additional fonts in the Google API fonts section
		below',
		'std' => 'default'
	),



	array(
		'type' => 'documentation',
		'text' => '<h3>Google API Fonts</h3>'
	),

	array(
		'name' => 'Enable Google Fonts',
		'id' => 'enable_google_fonts',
		'type' => 'checkbox',
		'std' =>true
	),

	array(
		'name'=>'Add Google Font',
		'id'=>'google_fonts',
		'type'=>'custom',
		'button_text'=>'Add Font',
		'fields'=>array(
			array( 'id'=>'name',
				'type'=>'text',
				'name'=>'Font Name / Font Family',
				'required'=>true ),
			array( 'id'=>'link',
				'type'=>'textarea',
				'name'=>'Font URL',
				'required'=>true ) ),
		'bind_to'=>array(
			'ids'=>array( 'headings_font_family', 'body_font_family', 'menu_font_family' ),
			'links'=>array( 'id'=>'link', 'name'=>'name' )
		),
		'desc'=>'In this field you can add or remove Google Fonts to the theme. 
			In the "Font Name / Font Family" field add the name of the font or a
			font family where the fonts are separated with commeas. In the 
			"Font URL" insert the URL of the font file. Please note that only 
			the font URL should be inserted here (the value that is set within 
			the "href" attribute of the embed link tag Google provides), 
			not the whole embed link tag.<br/><br/> <b>Example values:</b><br /> 
			<b>Font Name / Font Family: </b><br/>\'Archivo Narrow\', sans-serif<br/> 
			<b>Font URL: </b><br/>
			http://fonts.googleapis.com/css?family=Archivo+Narrow<br /><br/> 
			Once you add the font, it will be added to the default font list 
			available to select for each of the elements. For more information, 
			please refer to the "Fonts" section of the documentation included.',
		'std'=>array(array('name'=>"'Open Sans'", 'link'=>'http://fonts.googleapis.com/css?family=Open+Sans:400,700'))

	),


	array(
		'type' => 'close' ),


	/* ------------------------------------------------------------------------*
	 * ADDITIONAL STYLES
	 * ------------------------------------------------------------------------*/

	array(
		'type' => 'subtitle',
		'id' => 'add_styles'
	),

	array(
		'name' => 'Additional CSS styles',
		'id' => 'additional_styles',
		'type' => 'textarea',
		'large' => true,
		'desc' => 'You can insert some more additional CSS code here. If you would 
			like to do some modifications to the theme\'s CSS, it is better to 
			insert the modifications in this field rather than modifying the 
			original style.css file, as the modifications in this field will 
			remain saved trough the theme updates.'
	),

	array(
		'type' => 'close' ),


	array(
		'type' => 'close' ) );


$pexeto->options->add_option_set( $pexeto_styles_options );
