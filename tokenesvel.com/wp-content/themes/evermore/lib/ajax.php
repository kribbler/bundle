<?php
/**
 * Includes AJAX request handler functions.
 */

add_action( 'wp_ajax_pexeto_upload', 'pexeto_ajax_upload' );

if ( !function_exists( 'pexeto_ajax_upload' ) ) {

	/**
	 * Upload handler function. Uploads a file and loads the result in an array.
	 * If the file was uploaded successfully, the array contains the keys:
	 * - success : true
	 * - uploadurl : the URL of the upload directory
	 * - filename : the name of the uploaded file
	 * if the file as not uploaded successfully, the array contains the keys:
	 * - success : false
	 * - error : the error message
	 * The result is converted to a JSON string and echoed back as a responce.
	 */
	function pexeto_ajax_upload() {
		$res = array();
		if ( current_user_can( 'edit_posts' ) ) {
			$uploads_dir=wp_upload_dir();

			$uploaddir = $uploads_dir['path'];
			$uploadname=basename( $_FILES['pexetofile']['name'] );

			if ( file_exists( $uploaddir.'/'.$uploadname ) ) {
				$uploadname=time().$uploadname;
			}

			$uploadfile = $uploaddir.'/'.$uploadname;


			if ( move_uploaded_file( $_FILES['pexetofile']['tmp_name'], $uploadfile ) ) {
				$res['success']=true;
				$res['uploadurl']=$uploads_dir['url'];
				$res['filename']=$uploadname;
			} else {
				$res['success']=false;
			}
		}else {
			$res['success']=false;
			$res['error'] = 'You do not have permission to upload a file';
		}

		echo json_encode( $res );
		exit;
	}
}
