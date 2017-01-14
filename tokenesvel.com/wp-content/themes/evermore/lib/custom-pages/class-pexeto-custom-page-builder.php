<?php

/**
 * This class contains some templating functions - for building HTML code.
 *
 * @author Pexeto
 *
 */
class PexetoCustomPageBuilder {

	protected $default_term = '';

	function __construct( $default_term ) {
		$this->default_term = $default_term;
	}

	/**
	 * Builds a template for a single custom page list item.
	 *
	 * @param $post        the post object that represents the item
	 * @param $custom_page a custom page object that represents tha custom page
	 * @param $prefix      the prefix of the fields in the form
	 */
	public function get_custom_page_list_template( $post, $custom_page, $prefix ) {
		$add_class = $custom_page->minimizable ? ' class="minimized"':'';
		$html='<li id="'.$post->ID.'"'.$add_class.'>';
		if ( $custom_page->preview_image!='none' ) {
			$html.= '<img src="'.get_post_meta( 
				$post->ID, 
				$prefix.$custom_page->preview_image, 
				true ).'" data-input_field="'.$prefix.$custom_page->preview_image.'"/>';
		}
		$html.='<div class="item-wrapper">';
		foreach ( $custom_page->fields as $field ) {
			$required=isset( $field['required'] )?'required':'notrequired';
			$html.='<div class="item"><label>'.$field['name'].': </label><span class="'.$prefix.$field['id'].' '.$field['type'].' '.$required.'">';

			switch ( $field['id'] ) {
			case 'title':
				$html.=$post->post_title;
				break;
			case 'content':
				$html.=$post->post_content;
				break;
			default:
				$html.=get_post_meta( $post->ID, $prefix.$field['id'], true );
				break;
			}
			$html.='</span></div>';
		}
		$html.='</div><input type="hidden" value="'.$post->ID.'" id="itemid" name="itemid" /><div class="edit-button hover" title="Edit"></div><div class="delete-button hover" title="Delete"></div><div class="loading"></div></li>';

		return $html;
	}

	/**
	 * Returns the HTML that is before each item custom section.
	 *
	 * @param $title the title of the item
	 */
	public function get_before_custom_section( $title ) {
		$html= '<div class="custom-item-wrapper"><div class="ui-icon ui-icon-triangle-1-e arrow"></div><h3>'.$title.'</h3>';
		if ( $title!=$this->default_term ) {
			$html.='<div class="delete-slider-button hover"></div>';
		}
		$html.='<div class="custom-section">';
		return $html;
	}

	/**
	 * Returns the HTML that is after each item custom section.
	 */
	public function get_after_custom_section() {
		return '</div></div>';
	}

	/**
	 * Builds the template for a custom page form with all the input fields needed.
	 *
	 * @param $title       the title of the form
	 * @param $category    the category that corresponds to the current instance (each instance represents a different category)
	 * @param $custom_page a custom page object that represents the custom page
	 * @param $prefix      the prefix of the fields in the form
	 */
	public function get_custom_page_form_template( $title, $category, $custom_page, $prefix ) {
		$html='<div class="custom-container"><form class="custom-page-form"><table class="form-table">';

		foreach ( $custom_page->fields as $field ) {
			$colspan = isset( $field['two-column'] ) ? 1 : 2;
			if ( !isset( $field['two-column'] ) || ( isset( $field['two-column'] ) && $field['two-column']=='first' ) ) {
				$html.='<tr>';
			}

			$html.= '<td colspan="'.$colspan.'"><span class="custom-heading">'.$field['name'].'</span>';
			switch ( $field['type'] ) {
			case 'text':
				//print a standart text field
				$class=isset( $field['required'] )?'required':'';
				$html.= '<input type="text" id="'.$field['id'].'" name="'.$prefix.$field['id'].'" class="'.$class.' option-input"/>';
				break;
			case 'upload':
				$class=isset( $field['required'] ) && $field['required'] ?'required':'';
				$button_id='upload_button'.$category;
				$field_id=$field['id'];
				//print a field with an upload button
				$html.= '<input class="option-input upload pexeto-upload '.$class.'" name="'.$prefix.$field['id'].'" id="'.$field_id.'" type="text" />';
				$html.= '<a id="'.$button_id.'" class="upload-button pexeto-upload-btn pex-button" ><span><i aria-hidden="true" class="icon-upload"></i> Upload</span></a><br/>';
				//TODO maybe export the uploader functionality to a common JS file
				break;
			case 'textarea':
				//print a textarea
				$class=isset( $field['required'] )?'required':'';
				$html.= '<textarea id="'.$field['id'].'" name="'.$prefix.$field['id'].'" class="'.$class. ' option-input" "></textarea>';
				break;
			}
			$html.='</td>';

			if ( !isset( $field['two-column'] ) || ( isset( $field['two-column'] ) && $field['two-column']=='last' ) ) {
				$html.='</tr>';
			}
		}


		$html.='<tr><td colspan="2" class="last-td">';
		//display some hidden inputs with the main item data that may be used in AJAX requests later
		$html.='<input type="hidden" name="category" value="'.$category.'" class="category" />';
		$html.='<input type="hidden" name="default_title" value="'.$title.'" />';
		$html.='<input type="hidden" name="post_type" value="'.$custom_page->post_type.'" />';

		$html.='<div class="add-button-container"><div class="loading"></div>';
		//print the add button
		$html.= '<a class="custom-option-button pex-button" ><span><i aria-hidden="true" class="icon-plus"></i> Add Item</span></a></div>';

		$html.='</td></tr></table>';

		$html.='</form></div>';
		return $html;

	}
}
