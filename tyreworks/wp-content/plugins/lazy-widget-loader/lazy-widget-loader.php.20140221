<?php
/**
 * lazy-widget-loader.php
 * 
 * Copyright (c) 2011,2012 "kento" Karim Rahimpur www.itthinx.com
 * 
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 * 
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This header and all notices must be kept intact.
 * 
 * @author Karim Rahimpur
 * @package lazy-widget-loader
 * @since lazy-widget-loader 1.0.0
 *
 * Plugin Name: Lazy Widget Loader
 * Plugin URI: http://www.itthinx.com/plugins/lazy-widget-loader
 * Description: The Lazy Widget Loader provides a lazy loading mechanism that defers loading the content of selected widgets to the footer, allowing your main content to appear first. Use it on slow widgets, especially those that load content from external sources like Facebook, Twitter, AdSense, ... <strong>Go Pro!</strong> Enable advanced lazy loading mechanisms for <em>content and widgets</em> with <a href="http://www.itthinx.com/plugins/itthinx-lazyloader" target="_blank"><strong>Itthinx LazyLoader</strong></a>: <strong>Speed up page load time, on-demand asynchronous loading, lazy-loading shortcodes</strong>.
 * Version: 1.2.8
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com/plugins/itthinx-lazyloader
 * License: GPLv3
 */

/**
 * @var string plugin url
 */
define( 'LWL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * @var string plugin directory
 */
define( 'LWL_PLUGIN_DIR', dirname( __FILE__ ) );

/**
 * @var string plugin domain
 */
define( 'LWL_PLUGIN_DOMAIN', 'lazy-widget-loader' );

/** 
 * @var int throbber height
 */
define( 'LWL_THROBBER_HEIGHT', 16 );

/**
 * @var string options nonce
 */
define( 'LWL_OPTIONS_NONCE', "lwl-options-nonce" );

/**
 * Returns settings.
 * @return plugin settings
 */
function LWL_get_settings() {
    global $LWL_settings, $LWL_version;
    if ( !isset( $LWL_settings ) ) {
        $LWL_settings = _LWL_get_settings();
        $LWL_version = "current";
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( function_exists( 'get_plugin_data' ) ) {
            $plugin_data = get_plugin_data( __FILE__ );
            if ( !empty( $plugin_data ) ) {
                $LWL_version = $plugin_data['Version'];
            }
        }
    }
    return $LWL_settings;
}

/**
 * Retrieves an option from settings or default value.
 * @param string $option desired option
 * @param mixed $default given default value or null if none given
 */
function LWL_get_setting( $option, $default = null ) {
    $settings = LWL_get_settings();
    if ( isset( $settings[$option] ) ) {
        return $settings[$option];
    } else {
        return $default;
    }
}

/**
 * Retrieves plugin settings.
 * @return plugin settings
 * @access private
 */
function _LWL_get_settings() {
    return get_option( 'lazy-widget-loader-settings', array() );
}

/**
 * Updates plugin settings.
 * @param array $settings new plugin settings
 * @return bool true if successful, false otherwise
 * @access private
 */
function _LWL_update_settings( $settings ) {
    global $LWL_settings;
    $result = false;
    if ( update_option( 'lazy-widget-loader-settings', $settings ) ) {
        $result = true;
        $LWL_settings = get_option( 'lazy-widget-loader-settings', array() );
    }
    $css = LWL_generate_CSS();
    $css = preg_replace( "/\s+/", ' ', $css);
    if ( strlen( $css ) > 0 ) {
    	if ( LWL_update_CSS_file( $css ) ) {
    		$settings['load_widget_css'] = true;
    		$settings['generate_widget_css'] = false;
    	} else {
    		$settings['load_widget_css'] = false;
    		$settings['generate_widget_css'] = true;
    	}
    } else {
    	$settings['load_widget_css'] = false;
    	$settings['generate_widget_css'] = false;
    }
    if ( update_option( 'lazy-widget-loader-settings', $settings ) ) {
    	$result = true;
    	$LWL_settings = get_option( 'lazy-widget-loader-settings', array() );
    }
    return $result;
}

/**
 * Returns widgets.
 * @return widgets
 */
function LWL_get_widgets() {
    global $LWL_widgets;
    if ( !isset( $LWL_widgets ) ) {
        $LWL_widgets = array();
    }
    return $LWL_widgets;
}

/**
 * Determines the content of a widget.
 * @param string $id the widget id
 * @param string $widget_content the widget's content
 * @access private
 */
function _LWL_set_widget( $id, $widget_content ) {
    global $LWL_widgets;
    if ( !isset( $LWL_widgets ) ) {
        $LWL_widgets = array();
    }
    $LWL_widgets[$id] = $widget_content;
}

register_deactivation_hook( __FILE__, 'LWL_deactivate' );
/**
 * Removes plugin data if required.
 */
function LWL_deactivate() {
    if ( LWL_get_setting( "delete_data", false ) ) {
        delete_option( 'lazy-widget-loader-settings' );
    }
}

// ---------------------------------------------------
add_action( 'admin_menu', 'LWL_admin_menu' );
/**
 * Add administration options.
 */
function LWL_admin_menu() {
    if ( function_exists('add_submenu_page') ) {
        add_submenu_page(
        	'plugins.php',
        	__( 'Lazy Widget Loader Options', LWL_PLUGIN_DOMAIN ),
        	__( 'Lazy Widget Loader', LWL_PLUGIN_DOMAIN ),
        	'manage_options',
        	'lazy-widget-loader-options',
        	'LWL_options'
        );
    }
}

/**
 * Renders options screen and handles settings submission.
 */
function LWL_options() {
    if ( !current_user_can( "manage_options" ) ) {
        wp_die( __( 'Access denied.', LWL_PLUGIN_DOMAIN ) );
    }
    echo
        '<div>' .
            '<h2>' .
                __( 'Lazy Widget Loader Options', LWL_PLUGIN_DOMAIN ) .
            '</h2>' .
        '</div>';

    // handle form submission
    if ( isset( $_POST['submit'] ) ) {
        if ( wp_verify_nonce( $_POST[LWL_OPTIONS_NONCE], plugin_basename( __FILE__ ) ) ) {
            $settings = _LWL_get_settings();
            if ( !empty( $_POST['delete-data'] ) ) {
                $settings['delete_data'] = true;
            } else {
                $settings['delete_data'] = false;
            }
            _LWL_update_settings( $settings );
        }
    }
    $delete_data = LWL_get_setting( 'delete_data', false );
    // render options form
    echo
        '<form action="" name="options" method="post">' .
            '<div>' .
                '<h3>' . __( 'Settings', LWL_PLUGIN_DOMAIN ) . '</h3>' .
                '<p>' .
                    '<input name="delete-data" type="checkbox" ' . ( $delete_data ? 'checked="checked"' : '' ) . '/>' .
                    '<label for="delete-data">' . __( 'Delete settings when the plugin is deactivated', LWL_PLUGIN_DOMAIN ) . '</label>' .
                '</p>' .
                '<p>' .
                    wp_nonce_field( plugin_basename( __FILE__ ), LWL_OPTIONS_NONCE, true, false ) .
                    '<input type="submit" name="submit" value="' . __( 'Save', LWL_PLUGIN_DOMAIN ) . '"/>' .
                '</p>' .
            '</div>' .
        '</form>';
}

add_filter( 'plugin_action_links', 'LWL_plugin_action_links', 10, 2 );
/**
 * Adds an administrative link.
 * @param array $links
 * @param string $file
 */
function LWL_plugin_action_links( $links, $file ) {
    if ( $file == plugin_basename( dirname(__FILE__).'/lazy-widget-loader.php' ) ) {
        $links[] = '<a href="plugins.php?page=lazy-widget-loader-options">'.__( 'Options', LWL_PLUGIN_DOMAIN ).'</a>';
    }
    return $links;
}
// ---------------------------------------------------

add_action( 'wp_print_scripts', 'LWL_print_scripts' );
/**
 * Enqueues scripts for non-admin pages.
 */
function LWL_print_scripts() {
    global $LWL_version;
    if ( !is_admin() ) {
        wp_enqueue_script( 'lazy-widget-loader', LWL_PLUGIN_URL . 'js/lazy-widget-loader.js', array( 'jquery' ), $LWL_version, true );
    }
}

add_action( 'wp_footer', 'LWL_wp_footer' );
/**
 * Renders the widgets in the footer, moves them to their place when ready.
 */
function LWL_wp_footer() {
    $lazy_widget_loader_widgets = LWL_get_widgets();
    $settings = LWL_get_settings();
    if ( !empty( $lazy_widget_loader_widgets ) ) {
        // render the widgets
        echo '<div id="lwl-widget-contents">';
        foreach ( $lazy_widget_loader_widgets as $id => $content ) {
            if ( $settings[$id]['use'] ) { // actually not needed, but maybe later
                echo "<div class='lwl-widget' id='lwl-widget-$id'>$content</div>";
            }
        }
        echo '</div>'; // #lwl-widget-contents
    }
}

add_action( 'wp_print_styles', 'LWL_wp_print_styles' );
/**
 * Enqueues styles for non-admin pages.
 */
function LWL_wp_print_styles() {
    global $LWL_version;
    $settings = LWL_get_settings();
    if ( !isset($settings['load_widget_css'] ) ) {
    	_LWL_update_settings( $settings );
    	$settings = LWL_get_settings();
    }
    if ( !is_admin() ) {
        wp_enqueue_style( 'lazy-widget-loader', LWL_PLUGIN_URL . 'css/lwl.css', array(), $LWL_version );
        if ( $settings['load_widget_css'] ) {
        	wp_enqueue_style( 'lazy-widget-loader-css', LWL_PLUGIN_URL . 'css/lwl-widget.css', array(), $LWL_version );
        } else if ( $settings['generate_widget_css'] ) {
        	wp_enqueue_style( 'lazy-widget-loader-css', LWL_PLUGIN_URL . 'css/lwl-widget-css.php', array(), $LWL_version );
        }
    }
}

add_action( 'admin_print_styles', 'LWL_admin_print_styles' );
/**
 * Enqueues scripts for admin pages.
 */
function LWL_admin_print_styles() {
    global $LWL_version;
    if ( is_admin() ) {
        wp_enqueue_style( 'lazy-widget-loader-admin', LWL_PLUGIN_URL . 'css/lwl-admin.css', array(), $LWL_version );
    }
}

//add_action( 'admin_print_scripts-settings_page_plugin-admin-page', 'LWL_admin_print_scripts' );
add_action( 'admin_print_scripts', 'LWL_admin_print_scripts' );
function LWL_admin_print_scripts() {
    global $LWL_version;
    wp_enqueue_script( 'lazy-widget-loader-admin', LWL_PLUGIN_URL . 'js/lazy-widget-loader-admin.js', array( 'jquery' ), $LWL_version );
}

add_action( 'wp_head', 'LWL_widget_alter', 100 );
/**
 * Widget customization callback.
 * Alters widgets to add our customized options.
 */
function LWL_widget_alter() {
    global $wp_registered_widgets;
    foreach ( $wp_registered_widgets as $id => $widget ) {
        if ( ! isset( $wp_registered_widgets[$id]['LWL_original_callback'] ) ) {
            array_push( $wp_registered_widgets[$id]['params'], $id );
            $wp_registered_widgets[$id]['LWL_original_callback'] = $wp_registered_widgets[$id]['callback'];
            $wp_registered_widgets[$id]['callback'] = 'LWL_widget_alter_callback';
        }
    }
}

/**
 * Widget customization callback.
 * Wraps itself around the original callback.
 */
function LWL_widget_alter_callback() {
    global $wp_registered_widgets;
    $params = func_get_args();
    $id = array_pop( $params );
    $original_callback = $wp_registered_widgets[$id]['LWL_original_callback'];

    ob_start();
    call_user_func_array( $original_callback, $params );
    $widget_content = ob_get_contents();
    ob_end_clean();

    $settings = LWL_get_settings();

    if ( isset( $settings[$id]['use'] ) && $settings[$id]['use'] ) {
        if ( !function_exists( "IX_LL_lazyload" ) || ( isset( $settings[$id]['use-itthinx-lazyloader'] ) && ( $settings[$id]['use-itthinx-lazyloader'] === false ) ) ) {
            _LWL_set_widget( $id, $widget_content );
            $widget_content =
                '<div class="lwl-container" id="lwl-container-' . $id . '">' .
                    // we skip the original content in $widget_content for lazy loading
                '</div>';
        } else {
            $atts = array();
            if ( isset( $settings[$id]['min-width'] ) ) {
                $atts['min_width'] = intval( $settings[$id]['min-width'] );
            }
            if ( isset( $settings[$id]['min-height'] ) ) {
                $atts['min_height'] = intval( $settings[$id]['min-height'] );
            }
            if ( isset( $settings[$id]['width'] ) ) {
                $atts['width'] = intval( $settings[$id]['width'] );
            }
            if ( isset( $settings[$id]['height'] ) ) {
                $atts['height'] = intval( $settings[$id]['height'] );
            }
            if ( isset( $settings[$id]['offset'] ) ) {
                $atts['offset'] = intval( $settings[$id]['offset'] );
            }
            if ( isset( $settings[$id]['throbber'] ) ) {
                $atts['throbber'] =  $settings[$id]['throbber'];
            }
            if ( isset( $settings[$id]['load-on-sight'] ) ) {
                $atts['load_on_sight'] = $settings[$id]['load-on-sight'];
            }
            if ( isset( $settings[$id]['auto-noscript'] ) ) {
                $atts['auto_noscript'] = $settings[$id]['auto-noscript'];
            }
            if ( isset( $settings[$id]['mesosense'] ) ) {
                $atts['mesosense'] = $settings[$id]['mesosense'];
            }
            if ( isset( $settings[$id]['container'] ) ) {
                $atts['container'] = $settings[$id]['container'];
            }
            if ( isset( $settings[$id]['class'] ) ) {
                $atts['class'] = $settings[$id]['class'];
            }
            if ( isset( $settings[$id]['id'] ) ) {
                $atts['id'] = $settings[$id]['id'];
            }
            $widget_content = IX_LL_lazyload( $widget_content, $atts );
        }
    }
    echo $widget_content;
}

add_action( 'sidebar_admin_setup', 'LWL_widget_add_controls');
/**
 * Called upon entering the widget admin section.
 * Called when saving a widget's options.
 */
function LWL_widget_add_controls() {
    global $wp_registered_widgets, $wp_registered_widget_controls;

    $settings = LWL_get_settings();
    if ( 'post' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
        $widget_id = $_POST['widget-id'];
        if ( !empty( $widget_id ) ) {
            if ( ! isset ( $_POST[$widget_id . '-lazy-widget-loader-use'] ) ) {
                unset( $settings[$widget_id]['use'] );
            } else {
                $settings[$widget_id]['use'] = true;
            }
            if ( ! isset ( $_POST[$widget_id . '-lazy-widget-loader-throbber'] ) ) {
                unset( $settings[$widget_id]['throbber'] );
            } else {
                $settings[$widget_id]['throbber'] = true;
            }
            $min_width = isset( $_POST[$widget_id . '-lazy-widget-loader-min-width'] ) ? intval( $_POST[$widget_id . '-lazy-widget-loader-min-width'] ) : 0;
            if ( $min_width <= 0 ) {
                if ( isset( $settings[$widget_id]['min-width'] ) ) {
                    unset( $settings[$widget_id]['min-width'] );
                }
            } else {
                $settings[$widget_id]['min-width'] = $min_width;
            }
            $min_height = isset( $_POST[$widget_id . '-lazy-widget-loader-min-height'] ) ? intval( $_POST[$widget_id . '-lazy-widget-loader-min-height'] ) : 0;
            if ( $min_height <= 0 ) {
                if ( isset( $settings[$widget_id]['min-height'] ) ) {
                    unset( $settings[$widget_id]['min-height'] );
                }
            } else {
                $settings[$widget_id]['min-height'] = $min_height;
            }
            $width = isset( $_POST[$widget_id . '-lazy-widget-loader-width'] ) ? intval( $_POST[$widget_id . '-lazy-widget-loader-width'] ) : 0;
            if ( $width <= 0 ) {
                if ( isset( $settings[$widget_id]['width'] ) ) {
                    unset( $settings[$widget_id]['width'] );
                }
            } else {
                $settings[$widget_id]['width'] = $width;
            }
            $height = isset( $_POST[$widget_id . '-lazy-widget-loader-height'] ) ? intval( $_POST[$widget_id . '-lazy-widget-loader-height'] ) : 0;
            if ( $height <= 0 ) {
                if ( isset( $settings[$widget_id]['height'] ) ) {
                    unset( $settings[$widget_id]['height'] );
                }
            } else {
                $settings[$widget_id]['height'] = $height;
            }
            
            $offset = isset( $_POST[$widget_id . '-offset'] ) ? intval( $_POST[$widget_id . '-offset'] ) : 0;
            if ( $offset < 0 ) {
                if ( isset( $settings[$widget_id]['offset'] ) ) {
                    unset( $settings[$widget_id]['offset'] );
                }
            } else {
                $settings[$widget_id]['offset'] = $offset;
            }

            if ( ! isset ( $_POST[$widget_id . '-expand-options'] ) || ( intval( $_POST[$widget_id . '-expand-options'] ) === 0 ) ) {
                $settings[$widget_id]['expand-options'] = false;
            } else {
                $settings[$widget_id]['expand-options'] = true;
            }

            // itthinx-lazyloader options
            if ( ! isset ( $_POST[$widget_id . '-use-itthinx-lazyloader'] ) ) {
                $settings[$widget_id]['use-itthinx-lazyloader'] = false;
            } else {
                $settings[$widget_id]['use-itthinx-lazyloader'] = true;
            }
            if ( ! isset ( $_POST[$widget_id . '-load-on-sight'] ) ) {
                $settings[$widget_id]['load-on-sight'] = false;
            } else {
                $settings[$widget_id]['load-on-sight'] = true;
            }
            if ( ! isset ( $_POST[$widget_id . '-auto-noscript'] ) ) {
                $settings[$widget_id]['auto-noscript'] = false;
            } else {
                $settings[$widget_id]['auto-noscript'] = true;
            }
            if ( ! isset ( $_POST[$widget_id . '-mesosense'] ) ) {
                $settings[$widget_id]['mesosense'] = false;
            } else {
                $settings[$widget_id]['mesosense'] = true;
            }
            if ( ! isset ( $_POST[$widget_id . '-ll-container'] ) ) {
                unset( $settings[$widget_id]['container'] );
            } else {
                $settings[$widget_id]['container'] = trim( $_POST[$widget_id . '-ll-container'] );
                if ( empty( $settings[$widget_id]['container'] ) ) {
                    unset( $settings[$widget_id]['container'] );
                }
            }
            if ( ! isset ( $_POST[$widget_id . '-ll-class'] ) ) {
                unset( $settings[$widget_id]['class'] );
            } else {
                $settings[$widget_id]['class'] = trim( $_POST[$widget_id . '-ll-class'] );
                if ( empty( $settings[$widget_id]['class'] ) ) {
                    unset( $settings[$widget_id]['class'] );
                }
            }
            if ( ! isset ( $_POST[$widget_id . '-ll-id'] ) ) {
                unset( $settings[$widget_id]['id'] );
            } else {
                $settings[$widget_id]['id'] = trim( $_POST[$widget_id . '-ll-id'] );
                if ( empty( $settings[$widget_id]['id'] ) ) {
                    unset( $settings[$widget_id]['id'] );
                }
            }
            _LWL_update_settings( $settings );
        } // !empty( $widget_id )
    }
    foreach ( $wp_registered_widgets as $id => $widget ) {

        $alter_callback = false;
        if ( isset( $wp_registered_widget_controls[$id]['params'][0] ) && is_array( $wp_registered_widget_controls[$id]['params'][0] ) ) {
            $wp_registered_widget_controls[$id]['params'][0]['lazy-widget-loader-widget-id'] = $id;
            $alter_callback = true;
        } else if ( empty( $wp_registered_widget_controls[$id]['params'] ) ) {

            if ( !isset( $wp_registered_widget_controls[$id]['params'] ) || ( $wp_registered_widget_controls[$id]['params'] === null ) ) {
                // widgets that do not provide controls end up here with
                // params null, initialize params as an array so we
                // can add the id
                $wp_registered_widget_controls[$id]['params'] = array();
            }
            if ( is_array( $wp_registered_widget_controls[$id]['params'] ) ) {
                $wp_registered_widget_controls[$id]['params'][0]['lazy-widget-loader-widget-id'] = $id;
                $alter_callback = true;
            }
        }

        if ( $alter_callback ) {
            // replace the callback with our own
            $wp_registered_widget_controls[$id]['LWL_original_callback'] = isset( $wp_registered_widget_controls[$id]['callback'] ) ? $wp_registered_widget_controls[$id]['callback'] : null;
            $wp_registered_widget_controls[$id]['callback'] = 'LWL_widget_alter_controls';
        } else {
            if ( isset( $settings[$id] ) ) {
                unset( $settings[$id] );
                _LWL_update_settings( $settings );
            }
        }

    }
}

/**
 * Called when a widget's controls should be displayed.
 * Takes care of calling the original callback of the widget
 * and adding plugin-specific controls.
 * @see wp_register_widget_control() in wp_includes/widget.php
 */
function LWL_widget_alter_controls() {
    global $wp_registered_widget_controls;
    global $LWL_widget_count;
    if ( isset( $LWL_widget_count ) ) {
        $LWL_widget_count++;
    } else {
        $LWL_widget_count = 1;
    }
    $params = func_get_args();

    $settings = LWL_get_settings();

    $id = ( is_array ( $params[0] ) ) ? $params[0]['lazy-widget-loader-widget-id'] : array_pop( $params );
    $widget_id = $id;
    if ( is_array( $params[0] ) && isset( $params[0]['number'] ) ) {
        $number = $params[0]['number'];
    }
    if ( isset( $number ) && ( $number == -1 ) ) {
        // @see wp-admin/includes/widgets.php quoting:
        // number == -1 implies a template where id numbers are replaced by a generic '__i__'
        $number = '__i__';
        $value = "";
    }
    if ( isset( $number ) ) {
        $widget_id = $wp_registered_widget_controls[$id]['id_base'] . '-' . $number;
    }
    // call the original callback before adding our stuff
    $callback = ( isset( $wp_registered_widget_controls[$id]['LWL_original_callback'] ) ? $wp_registered_widget_controls[$id]['LWL_original_callback'] : '' );
    if ( is_callable( $callback ) ) {
        call_user_func_array( $callback, $params );
    }

    if ( isset( $settings[$widget_id]['expand-options'] ) && ( $settings[$widget_id]['expand-options'] === true ) ) {
        $toggler_class = "retract";
        $options_class = "";
        $expand_options = "1";
    } else {
        $toggler_class = "expand";
        $options_class = "hidden";
        $expand_options = "0";
    }

    $options_prefix  = '<div class="options-view">';
    $options_prefix .= '<noscript>';
    $options_prefix .= '<style type="text/css">';
    $options_prefix .= 'div.lazy-widget-loader.widget-controls .hidden { display: block ! important; }';
    $options_prefix .= '</style>';
    $options_prefix .= '</noscript>';
    $options_prefix .= '<div id="toggler-' . $LWL_widget_count . '" class="options-view-toggle '.$toggler_class.'">' . __( 'Options', LWL_PLUGIN_DOMAIN ) . '</div>';
    $options_prefix .= '<input class="options-view-expand" type="hidden" name="' . $widget_id . '-expand-options" value="' . $expand_options . '" />';
    $options_prefix .= "<div class='options-view-content $options_class'>";

    $options_suffix  = "</div>"; // .options-view-content
    $options_suffix .= "</div>"; // .options-view

    // now add our stuff
    if ( function_exists( "IX_LL_lazyload" ) ) {
        echo '<div class="lazy-widget-loader widget-controls lazy-widget-loader itthinx-lazyloader">';
    } else {
        echo '<div class="lazy-widget-loader widget-controls lazy-widget-loader">';
    }

    // use loader?
    $checked = ( ( isset( $settings[$widget_id]['use'] ) && $settings[$widget_id]['use'] ) ? 'checked="checked"' : '' );
    echo '<div class="section top">';
    echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-lazy-widget-loader-use"/>';
    echo '<label class="title" for="' . $widget_id . '-lazy-widget-loader-use">' . __( 'Lazy Loading', LWL_PLUGIN_DOMAIN ) . '</label>';
    echo '</div>';

    // check for itthinx lazyloader & show primary options
    if ( function_exists( "IX_LL_lazyload" ) ) {
        // use by default
        $checked = ( ( !isset( $settings[$widget_id]['use-itthinx-lazyloader'] ) || ( $settings[$widget_id]['use-itthinx-lazyloader'] === true ) ) ? 'checked="checked"' : '' );
        echo '<div class="section">';
        echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-use-itthinx-lazyloader"/>';
        echo '<label class="title" title="' . __( "Use the advanced loading mechanism instead of just loading in the footer.", LWL_PLUGIN_DOMAIN ) .'" for="' . $widget_id . '-use-itthinx-lazyloader">' . __( 'Use <a href="http://www.itthinx.com/plugins/itthinx-lazyloader" target="_blank">Itthinx LazyLoader</a>', LWL_PLUGIN_DOMAIN ) . '</label>';
        if ( !isset( $settings[$widget_id]['use'] ) || ( $settings[$widget_id]['use'] === false ) ) {
            echo '<br/>';
            echo '<span class="description warning">' . __( "<b>Lazy Loading</b> <i>must</i> be enabled to activate this option.", LWL_PLUGIN_DOMAIN ) . '</span>';
        }
        echo '</div>';

        echo $options_prefix;

        // load on sight
        $checked = ( ( !isset( $settings[$widget_id]['load-on-sight'] ) || ( $settings[$widget_id]['load-on-sight'] === true ) ) ? 'checked="checked"' : '' );
        echo '<div class="section">';
        echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-load-on-sight"/>';
        echo '<label class="title" title="' . __( "Will load content only when it enters the viewport.", LWL_PLUGIN_DOMAIN ) .'" for="' . $widget_id . '-load-on-sight">' . __( 'Load on sight', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '</div>';

        // offset
        echo '<div class="section">';
        $widget_offset_option_id = $widget_id . '-offset';
        if ( isset( $settings[$widget_id]['offset'] ) ) {
            $offset = intval( $settings[$widget_id]['offset'] );
            if ( $offset < 0 ) {
                $offset = 0;
            }
        } else {
            $offset = 0;
        }
        echo '<label class="offset" for="' . $widget_offset_option_id .'">' . __( 'Offset', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '<input class="offset" size="3" name="' . $widget_offset_option_id . '" type="text" value="' . esc_attr( $offset ) . '">';
        echo '<span class="description">px</span>';
        echo '</div>'; // .section

        // auto-noscript
        $checked = ( ( !isset( $settings[$widget_id]['auto-noscript'] ) || ( $settings[$widget_id]['auto-noscript'] === true ) ) ? 'checked="checked"' : '' );
        echo '<div class="section">';
        echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-auto-noscript"/>';
        echo '<label title="' . __( "Automatically generates noscript tags to provide alternative content used when a visitor has JavaScript disabled.", LWL_PLUGIN_DOMAIN ) .'" for="' . $widget_id . '-auto-noscript">' . __( 'Automatic noscript', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '</div>';

        // mesosense
        $checked = ( ( isset( $settings[$widget_id]['mesosense'] ) && ( $settings[$widget_id]['mesosense'] === true ) ) ? 'checked="checked"' : '' );
        echo '<div class="section">';
        echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-mesosense"/>';
        echo '<label title="' . __( "This setting can help to load content when normal loading fails. Unless that happens, don't turn this option on.", LWL_PLUGIN_DOMAIN ) . '" for="' . $widget_id . '-mesosense">' . __( 'Use mesosense', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '</div>';

    } else {
        echo '<div class="section">'; 
        echo __( '<span style="font-weight:bold;font-style:italic;color:#093;">Go Pro!</span> <a title="The Itthinx LazyLoader for content and widgets, helps to greatly improve page load time and bandwidth usage. Power SEO by improving site speed!" href="http://www.itthinx.com/plugins/itthinx-lazyloader" target="_blank">Itthinx LazyLoader</a>' );
        echo '</div>';

        echo $options_prefix;
    }

    // use throbber?
    $checked = ( ( isset($settings[$widget_id]['throbber']) && $settings[$widget_id]['throbber'] ) ? 'checked="checked"' : '' );
    echo '<div class="section">';
    echo '<input type="checkbox" ' . $checked . ' value="1" name="' . $widget_id . '-lazy-widget-loader-throbber"/>';
    echo '<label class="throbber-option" for="' . $widget_id . '-lazy-widget-loader-throbber">' . __( 'Throbber', LWL_PLUGIN_DOMAIN ) . '</label>';

    echo '</div>';

    // widget minimum width
    $widget_min_width_option_id = $widget_id.'-lazy-widget-loader-min-width';
    if ( isset( $settings[$widget_id]['min-width'] ) ) {
        $min_width = intval( $settings[$widget_id]['min-width'] );
        if ( $min_width <= 0 ) {
            $min_width = '';
        }
    } else {
        $min_width = '';
    }

    echo '<div class="section">';

    echo '<label class="min-width" for="' . $widget_min_width_option_id .'">' . __( 'Minimum Width', LWL_PLUGIN_DOMAIN ) . '</label>';
    echo '<input class="min-width" size="3" name="' . $widget_min_width_option_id . '" type="text" value="' . esc_attr( $min_width ) . '">';
    echo '<span class="description">px</span>';

    // widget width
    $widget_width_option_id = $widget_id.'-lazy-widget-loader-width';
    if ( isset( $settings[$widget_id]['width'] ) ) {
        $width = intval( $settings[$widget_id]['width'] );
        if ( $width <= 0 ) {
            $width = '';
        }
    } else {
        $width = '';
    }

    echo '<label class="width" for="' . $widget_width_option_id .'">' . __( 'Width', LWL_PLUGIN_DOMAIN ) . '</label>';
    echo '<input class="width" size="3" name="' . $widget_width_option_id . '" type="text" value="' . esc_attr( $width ) . '">';
    echo '<span class="description">px</span>';

    echo '</div>'; // .section

    echo '<div class="section bottom">';

    // widget minimum height
    $widget_min_height_option_id = $widget_id.'-lazy-widget-loader-min-height';
    if ( isset( $settings[$widget_id]['min-height'] ) ) {
        $min_height = intval( $settings[$widget_id]['min-height'] );
        if ( $min_height <= 0 ) {
            $min_height = '';
        }
    } else {
        $min_height = '';
    }
    echo '<label class="min-height" for="' . $widget_min_height_option_id .'">' . __( 'Minimum Height', LWL_PLUGIN_DOMAIN ) . '</label>';
    echo '<input class="min-height" size="3" name="' . $widget_min_height_option_id . '" type="text" value="' . esc_attr( $min_height ) . '">';
    echo '<span class="description">px</span>';

    // widget height
    $widget_height_option_id = $widget_id.'-lazy-widget-loader-height';
    if ( isset( $settings[$widget_id]['height'] ) ) {
        $height = intval( $settings[$widget_id]['height'] );
        if ( $height <= 0 ) {
            $height = '';
        }
    } else {
        $height = '';
    }
    echo '<label class="height" for="' . $widget_height_option_id .'">' . __( 'Height', LWL_PLUGIN_DOMAIN ) . '</label>';
    echo '<input class="height" size="3" name="' . $widget_height_option_id . '" type="text" value="' . esc_attr( $height ) . '">';
    echo '<span class="description">px</span>';

    echo '</div>'; // .section

    // itthinx-lazyloader secondary options
    if ( function_exists( "IX_LL_lazyload" ) ) {

        // container
        $container = "";
        if ( isset( $settings[$widget_id]['container'] ) ) {
            $container = $settings[$widget_id]['container'];
        }
        echo '<div class="section">';
        echo '<label class="container" for="' . $widget_id .'-ll-container">' . __( 'Container', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '<input class="container" name="' . $widget_id . '-ll-container" type="text" value="' . esc_attr( $container ) . '">';
        echo '</div>';

        // class
        $class = "";
        if ( isset( $settings[$widget_id]['class'] ) ) {
            $class = $settings[$widget_id]['class'];
        }
        echo '<div class="section">';
        echo '<label class="class" for="' . $widget_id .'-ll-class">' . __( 'Class', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '<input class="class" name="' . $widget_id . '-ll-class" type="text" value="' . esc_attr( $class ) . '">';
        echo '</div>';

        // id
        $id = "";
        if ( isset( $settings[$widget_id]['id'] ) ) {
            $id = $settings[$widget_id]['id'];
        }
        echo '<div class="section">';
        echo '<label class="id" for="' . $widget_id .'-ll-id">' . __( 'Id', LWL_PLUGIN_DOMAIN ) . '</label>';
        echo '<input class="id widefat" name="' . $widget_id . '-ll-id" type="text" value="' . esc_attr( $id ) . '">';
        echo '</div>';
    }

    echo $options_suffix;

    echo '</div>'; // .lazy-widget-loader .widget-controls

    echo '
    <script type="text/javascript">
    LWLToggler("#toggler-' . $LWL_widget_count . '");
    </script>
    ';
}

function LWL_update_CSS_file( $css ) {
	if ( !file_exists( LWL_PLUGIN_DIR . '/css' ) ) {
		mkdir( LWL_PLUGIN_DIR . '/css', 0755, true );
	}
	$outfile = LWL_PLUGIN_DIR . '/css/lwl-widget.css';
	$out = @fopen( $outfile , "wb");
	$bytes = false;
	$success = false;
	if ( $out !== false ) {
		$bytes = @fwrite( $out, $css );
		$success = @fclose( $out );
	}
	return ( $out !== false ) && ( $bytes !== false ) && $success;
}

function LWL_generate_CSS() {
	$output = "";
	$settings = LWL_get_settings();
	if ( !empty( $settings ) ) {
		foreach ( $settings as $id => $values ) {
			if ( isset( $settings[$id]['use'] ) && $settings[$id]['use'] ) {
				$width = 0;
				$min_width = 0;
				$height = 0;
				$min_height = 0;
				$throbber = false;
				if ( isset( $settings[$id]['throbber'] ) ) {
					$throbber = true;
				}
				if ( isset( $settings[$id]['width'] ) ) {
					$width = intval( $settings[$id]['width'] );
				}
				if ( isset( $settings[$id]['height'] ) ) {
					$height = intval( $settings[$id]['height'] );
				}
				if ( isset( $settings[$id]['min-width'] ) ) {
					$min_width = intval( $settings[$id]['min-width'] );
				}
				if ( isset( $settings[$id]['min-height'] ) ) {
					$min_height = intval( $settings[$id]['min-height'] );
				}
				if ( $throbber ) {
					$min_height = max( array( LWL_THROBBER_HEIGHT, $min_height ) );
				}
				if ( $throbber || ( $min_width > 0 ) || ( $min_height > 0 ) || ( $width > 0 ) || ( $height > 0 ) ) {
					if ( $throbber ) {
						$output .= "#lwl-container-$id {";
						$output .= 'background: url(../images/throbber.gif) transparent center center no-repeat;';
						if ( $min_height > 0 ) {
							$output .= "min-height: $min_height"."px;";
						}
						$output .= '}' . "\n";
					}
					$output .= "#lwl-widget-$id {";
					if ( $min_width > 0 ) {
						$output .= "min-width: $min_width"."px;";
					}
					if ( $min_height > 0 ) {
						$output .= "min-height: $min_height"."px;";
					}
					if ( $width > 0 ) {
						$output .= "width: $width"."px;";
					}
					if ( $height > 0 ) {
						$output .= "height: $height"."px;";
					}
					$output .= '}' . "\n";
				}
			}
		}
	}
	return $output;
}

add_action( 'init', 'LWL_init' );

/**
 * Initialization.
 * - Loads the plugin's translations.
 */
function LWL_init() {
	load_plugin_textdomain( LWL_PLUGIN_DOMAIN, null, 'lazy-widget-loader/languages' );
}
