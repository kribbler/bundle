<?php
header("Content-Type:text/javascript");

//Setup URL to WordPress
$absolute_path = __FILE__;
$path_to_wp = explode( 'wp-content', $absolute_path );
$wp_url = $path_to_wp[0];

//Access WordPress
require_once( $wp_url.'/wp-load.php' );

//URL to TinyMCE plugin folder
$plugin_url = get_template_directory_uri().'/includes/shortcodes/tinymce/';
?>
(function(){
	var icon_url = '<?php echo $plugin_url; ?>' + 'images/icon_shortcodes.png';
	tinymce.create(
		'tinymce.plugins.MyThemeShortcodes',
		{
			init: function(d, pliginUrl)
			{
				this._commandPluginUrl = pliginUrl;
				if ('4' == tinyMCE.majorVersion) {
					jQuery('<style>.mce-ico.mce-i-shortcodes_button{background:url('+icon_url+') left top no-repeat;}></style>')
						.appendTo('head');

					d.addButton('shortcodes_button',{
						type:'menubutton',
						title:'Insert Shortcode',
						menu:this.getMenuStructure()
					});
				} else { // fallback for the wp 3.8 with tinyMCE 3.X
					d.addButton('shortcodes_button',{
						title:'Insert Shortcode',
						image:icon_url
					});
				}
				d.addCommand('insertThemeShortcode', this._commandInsertShortcode, this);
			},

			_getShortcodesMenuItemsMap: function()
			{
				return {
					'Dynamic': {
						'Services':{
							'Carousel': 'services_carousel',
							'List': 'services_list',
							'Featured':'featured_services'
						},
						'Testimonials':'testimonials',
						'Team':'team',
						'Recent posts':'recent_posts',
						'Recent projects':'recent_projects'
					},
					'Grid':{
						'Row': 'row',
						'Column 1 (70px)': 'column_1',
						'Column 2 (170px)': 'column_2',
						'Column 3 (270px)': 'column_3',
						'Column 4 (370px)': 'column_4',
						'Column 5 (470px)': 'column_5',
						'Column 6 (570px)': 'column_6',
						'Column 7 (670px)': 'column_7',
						'Column 8 (770px)': 'column_8',
						'Column 9 (870px)': 'column_9',
						'Column 10 (970px)': 'column_10',
						'Column 11 (1070px)': 'column_11',
						'Column 12 (1170px)': 'column_12'
					},
					'Typography':{
						'Dividers':{
							'Double blue':'divider_blue',
							'Grey':'divider_grey'
						},
						'Titles':{
							'Small':'title_small',
							'Big':'title_big',
							'Blue line':'title_blue',
							'Pink':'title_pink'
						},
						'Links':{
							'Standard':'link',
							'Full width':'link_full_width'
						},
						'Explanation texts':{
							'Arrow 1':'explanation_arrow1',
							'Arrow 2':'explanation_arrow2'
						},
						'Lists':{
							//'Decimal':'list_decimal',
							//'Square':'list_square',
							'Arrow':'list_arrow',
							'Vertical line':'list_vertical_line'
						},
						'Dropcaps':{
							'Square':'dropcap_square',
							'Circle':'dropcap_circle',
							'Letter':'dropcap_letter'
						},
						'Tooltips':{
							'Dark':'tooltip_dark',
							'Blue':'tooltip_blue',
							'Grey':'tooltip_grey',
							'Pink':'tooltip_pink'
						},
						'Font size':'font',
						'Quote':'quote'
					},
					'Boxes':{
						'Alert':{
							'Error':'error',
							'Warning':'warning',
							'Info':'info',
							'Success':'success'
						},
						'Promo':'promo',
						'Action':'action',
						'Double':'double_box'
					},
					'Elements':{
						'Pricing tables':{
							'3 columns':'pricing_table3',
							'4 columns':'pricing_table4',
							'5 columns':'pricing_table5'
						},
						'Tabs':{
							'Horizontal':'tabs',
							'Vertical':'tabs_vertical'
						},
						'Accordion':{
							'Style 1':'accordion1',
							'Style 2':'accordion2',
							'Style 3':'accordion3'
						},
						'Image border':{
							'Left alignment':'border_left',
							'Right alignment':'border_right'
						},
						'Table':'table',
						'Button':'button'
					},
					'Sliders':{
						'Roundabout carousel':'roundabout_carousel'
					},
					'Appic specials':{
						'Timeline':'timeline',
						'Appic UNIVERSE':'appic_universe',
						'Address':'address'
					}
				};
			},

			_commandInsertShortcode:function(a,c)
			{
				var selectedText = tinyMCE.activeEditor.selection.getContent(),
					myThemeSelectedShortcodeType = c.identifier,
					myThemeSelectedShortcodeTitle = c.title;
					shortcodeInsertText = '['+myThemeSelectedShortcodeType+']';
				switch ( myThemeSelectedShortcodeType ) {
					/**
					 * Dynamic
					 */
					case 'services_carousel': // Services
					case 'testimonials': // Testimonials
					case 'team': // Team
					case 'recent_projects': // Recent projects
						// code for this shorcodes is [{shorcode}] is ok
						break;

					case 'services_list': // Services list
						shortcodeInsertText = '[services_list number="5" show_featured="Yes"]';
						break;

					case 'recent_posts': // Recent posts
						// show_content="no"
						shortcodeInsertText = '[recent_posts number="1" title="Recent" subtitle="posts"]';
						break;

					/**
					 * Grid
					 */
					// Row
					case 'row':
						shortcodeInsertText = '[row][/row]';
						break;

					// Column X
					case 'column_1':
					case 'column_2':
					case 'column_3':
					case 'column_4':
					case 'column_5':
					case 'column_6':
					case 'column_7':
					case 'column_8':
					case 'column_9':
					case 'column_10':
					case 'column_11':
					case 'column_12':
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+']'+selectedText+'[/'+myThemeSelectedShortcodeType+']';
						break;

					/**
					 * Typography
					 */
					case 'divider_blue': // Divider - Double blue
					case 'divider_grey': // Divider - Grey
						break;

					case 'title_small': // Title - Small
					case 'title_big': // Title - Big
					case 'title_pink': // Title - Pink
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+' bottom_margin="no" small_text="Appic"]'+selectedText+'[/'+myThemeSelectedShortcodeType+']';
						break;

					// Title - Blue Line
					case 'title_blue':
						shortcodeInsertText = '[title_blue bottom_margin="no"]'+selectedText+'[/title_blue]';
						break;

					case 'link': // Link - Standard
					case 'link_full_width': // Link - Full width
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+' label="Link label" url="http://yoursite.com"]';
						break;

					case 'explanation_arrow1': // Explanation - Arrow 1
					case 'explanation_arrow2': // Explanation - Arrow 2
						var text = selectedText ? selectedText : 'Insert text here';
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+']'+text+'[/'+myThemeSelectedShortcodeType+']';
						break;

					case 'list_decimal': // List - Decimal
					case 'list_square': // List - Square
					case 'list_arrow': // List - Arrow
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+'][item]Item 1[/item][item]Item 2[/item][/'+myThemeSelectedShortcodeType+']';
						break;

					case 'list_vertical_line': // List - Vertical line
						shortcodeInsertText = '[list_vertical_line]' + 
							'[item_vertical_line title="Title 1"]Item 1[/item_vertical_line]' + 
							'[item_vertical_line title="Title 2"]Item 2[/item_vertical_line]' + 
						'[/list_vertical_line]';
						break;

					case 'dropcap_square': // Dropcap - Square
					case 'dropcap_circle': // Dropcap - Circle
					case 'dropcap_letter': // Dropcap - Letter
						var style = myThemeSelectedShortcodeType.replace('dropcap_', ''),
							text = selectedText ? selectedText : 'Insert text here';
						shortcodeInsertText = '[dropcap style="'+style+'"]'+text+'[/dropcap]';
						break;

					case 'tooltip_dark': // Tooltip - Dark
					case 'tooltip_blue': // Tooltip - Blue
					case 'tooltip_grey': // Tooltip - Grey
					case 'tooltip_pink': // Tooltip - Pink
						var color = myThemeSelectedShortcodeType.replace('tooltip_', ''),
							text = selectedText ? selectedText : 'Insert text here';
						shortcodeInsertText = '[tooltip color="'+color+'" hint="Insert the text hint"]'+text+'[/tooltip]';
						break;

					case 'font': // Font size
						shortcodeInsertText = '[font size="12"][/font]';
						break;

					case 'quote': // Quote
						var text = selectedText ? selectedText : 'Insert quote here';
						shortcodeInsertText = '[quote author="Author name"]'+text+'[/quote]';
						break;

					/**
					 * Boxes
					 */
					case 'error': // Box - Error
					case 'warning': // Box - Warning
					case 'info': // Box - Info
					case 'success': // Box - Success
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+']'+selectedText+'[/'+myThemeSelectedShortcodeType+']';
						break;

					case 'action': // Box - Action
						shortcodeInsertText = '[action link="http://yoursite.com" title="Title" button="Button text"]'+selectedText+'[/action]';
						break;

					case 'double_box': // Box - Double
						shortcodeInsertText = '[double_box]' + 
							'[double_box_column position="left"]Box 1[/double_box_column]' + 
							'[double_box_column position="right"]Box 2[/double_box_column]' + 
						'[/double_box]';
						break;

					/**
					 * Elements
					 */
					case 'pricing_table3': // Pricing Tables - 3 Columns
						shortcodeInsertText = '[pricing_table columns="3"]' + 
							'[pricing_column title="Title" price="$ 0.00" button_text="Purchase" button_url="#"]' + 
								'[pricing_item]Parameter 1[/pricing_item]' + 
								'[pricing_item]Parameter 2[/pricing_item]' + 
							'[/pricing_column]' + 
						'[/pricing_table]';
						break;

					// Pricing Tables - 4 Columns
					case 'pricing_table4':
						shortcodeInsertText = '[pricing_table columns="4"]' + 
							'[pricing_column title="Title" price="$ 0.00" button_text="Purchase" button_url="#"]' + 
								'[pricing_item]Parameter 1[/pricing_item]' + 
								'[pricing_item]Parameter 2[/pricing_item]' + 
							'[/pricing_column]' + 
							'[pricing_column title="Title" title_class="" price="$ 0.00" button_text="Purchase" button_url="#" button_class=""]' + 
								'[pricing_item]Parameter 1[/pricing_item]' + 
								'[pricing_item]Parameter 2[/pricing_item]' + 
							'[/pricing_column]' + 
						'[/pricing_table]';
						break;

					// Pricing Tables - 5 Columns
					case 'pricing_table5':
						shortcodeInsertText = '[pricing_table columns="5"]' + 
							'[pricing_column title="Title" price="$ 0.00" button_text="Purchase" button_url="#" button_class="btn-info" title_class="grey-table-head"]' + 
								'[pricing_item]Parameter 1[/pricing_item]' + 
								'[pricing_item]Parameter 2[/pricing_item]' + 
							'[/pricing_column]' + 
							'[pricing_column title="Title" title_class="pink-text" price="$ 0.00" button_text="Purchase" button_url="#" button_class="btn-danger"]' + 
								'[pricing_item]Parameter 1[/pricing_item]' + 
								'[pricing_item]Parameter 2[/pricing_item]' + 
							'[/pricing_column]' + 
						'[/pricing_table]';
						break;

					case 'tabs': // Tabs - Horizontal
					case 'tabs_vertical': // Tabs - Vertical
						shortcodeInsertText = '['+myThemeSelectedShortcodeType+' tab1="Title 1" tab2="Title 2" tab3="Title 3"][tab1]Tab 1 content...[/tab1][tab2]Tab 2 content...[/tab2][tab3]Tab 3 content...[/tab3][/'+myThemeSelectedShortcodeType+']';
						break;

					// Table
					case 'table':
						shortcodeInsertText = '[table]' + 
							'[head][table_row]' + 
								'[column]Title 1[/column][column]Title 2[/column][column]Title 3[/column][column]Title 4[/column][column]Title 5[/column]' +
							'[/table_row][/head]' +
							'[body]' +
								'[table_row][column]1[/column][column]2[/column][column]3[/column][column]4[/column][column]5[/column][/table_row]'+
								'[table_row][column]1[/column][column]2[/column][column]3[/column][column]4[/column][column]5[/column][/table_row]'+
							'[/body]'+
						'[/table]';
						break;

					case 'accordion1': // Accordion - Style 1
					case 'accordion2': // Accordion - Style 2
					case 'accordion3': // Accordion - Style 3
						var styleIndex = myThemeSelectedShortcodeType.replace('accordion','');
						shortcodeInsertText = '[accordion style="'+styleIndex+'"][toggle title="Title 1"]Content 1[/toggle][toggle title="Title 2"]Content 2[/toggle][/accordion]';
						break;

					case 'border_left': // Image border - Left
					case 'border_right': // Image border - Right
						var side = myThemeSelectedShortcodeType.replace('border_','');
						shortcodeInsertText = '[border alignment="'+side+'"]Insert image here[/border]';
						break;

					// Carousel roundabout
					case 'roundabout_carousel':
						shortcodeInsertText = '[roundabout_carousel][item]Insert image here[/item][item]Insert image here[/item][item]Insert image here[/item][/roundabout_carousel]';
						break;

					/**
					 * Appic Specials
					 */
					// Timeline
					case 'timeline':
						shortcodeInsertText = '[timeline][year x="2012"][time_item date="Dec 21 2010" position="bottom" month="December" ][/time_item][/timeline]';
						break;

					case 'address':
					case 'promo':
					case 'button':
					case 'featured_services': // Featured
					default:
						shortcodeInsertText = '';
						// all requires dialog
						break;
					} // End SWITCH Statement

				if (shortcodeInsertText) {
					tinyMCE.activeEditor.execCommand("mceInsertContent", false, shortcodeInsertText);
				} else { //loading and rendering of the settings dialog
					jQuery.get(this._commandPluginUrl+"/dialog.php",function(b){
						window.themePluginShortcodeInsertCurShortcode = myThemeSelectedShortcodeType;

						jQuery('#shortcode-options').
							addClass('shortcode-' + myThemeSelectedShortcodeType );

						jQuery("#dialog").remove();
						jQuery("body").append(b);
						jQuery("#dialog").hide();
						
						var width = jQuery(window).width();
							width= 720 < width ? 720 : width;
							width-=80;

						var height = jQuery(window).height() - 84;
						
						jQuery("#shortcode-options h3:first").text(
							myThemeSelectedShortcodeTitle+" Shortcode Settings"
						);
						tb_show(
							"Insert "+ myThemeSelectedShortcodeTitle +" Shortcode",
							"#TB_inline?width="+width+"&height="+height+"&inlineId=dialog"
						);
					});
				};
			},

			getMenuStructure: function()
			{
				var shortcodesMenuItems = this._getShortcodesMenuItemsMap();

				var _getSub = function(btntext, details){
					if (typeof details == 'string') {
						return {
							text: btntext,
							// name: 'btn-' + details,
							id:'btn-' + details,
							onclick: function(ev){
								//var btn = jQuery(ev.target),
								//	shortcodeName = btn.attr('id').replace(/^id-(.*)-text$/,'$1');
								tinyMCE.activeEditor.execCommand(
									'insertThemeShortcode',
									false,
									{title:btntext,identifier:details}
								);
							}
						};
					} else {
						var r = [],
							t;
						for(t in details) {
							r.push(_getSub(t, details[t]));
						};
						return {
							text: btntext,
							//type: 'menubutton',
							menu: r
						};
					}
				};

				var result = [],
					btext;
				for (btext in shortcodesMenuItems) {
					result.push(_getSub(btext, shortcodesMenuItems[btext]));
				}

				return result;
			},

			// fallback for tinyMCE 3.X [start]
			createControl: function(d, e)
			{
				if('shortcodes_button' != d){
					return null;
				}

				var self = this;
				d = e.createMenuButton('shortcodes_button',{
					title:"Insert Shortcode",
					image:icon_url
				});
				d.onRenderMenu.add(function(c,b){
					var items = self._getShortcodesMenuItemsMap();
					for(var title in items) {
						self._createControl_menuBuilder(b, title, items[title]);
					}
				});
				return d;
			},

			_createControl_menuBuilder:function(item, title, info)
			{
				if (typeof info == 'string') {
					item.add({
						title: title,
						onclick:function(){
							tinyMCE.activeEditor.execCommand('insertThemeShortcode',false,{
								title:title,
								identifier:info
							});
						}
					});
				} else {
					var nItem = item.addMenu({
						title:title
					});
					for(var cTitle in info) {
						this._createControl_menuBuilder(nItem, cTitle, info[cTitle]);
					}
				}
			},
			// fallback for tinyMCE 3.X [end]

			getInfo:function(){
				return{
					longname:"Shortcode Generator",
					author:"VisualShortcodes.com",
					authorurl:"http://visualshortcodes.com",
					infourl:"http://visualshortcodes.com/shortcode-ninja",
					version:"1.0"
				};
			}
		}
	);

	tinymce.PluginManager.add('MyThemeShortcodes',tinymce.plugins.MyThemeShortcodes);
})();
