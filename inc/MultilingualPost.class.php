<?php
//MultilingualPost inserting API data to wordpress post with WPML

class MultilingualPost {


	private function weblanguages() {
		//get languages from web
		$defaultlang = $sitepress->get_default_language();
		$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
		
		foreach ($languages as $key => $value) {
			$loc[] = $key;
		}

		return $loc;
	}

	public function publish(WP_REST_Request $request) {
		global $sitepress;

		//read data from json request
		$getjson = $request->get_json_params();

		//get original post
		$original = $getjson['original'];

		//get information inside translations json request
		$translations = $getjson['translations'];

		//get languages from web
		$defaultlang = $sitepress->get_default_language();
		$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
		foreach ($languages as $key => $value) {
			$loc[] = $key;
		}
		//get languages from json request
		$locale[] = $defaultlang;
		foreach ($translations as $lang => $value) {
				$locale[] = $lang;
		}

		//check if there are the same languages from json request and in website
		if (count($locale) == count($loc) && ksort($locale) == ksort($loc)) {

			//get original post columns
			$originalpost = array();
			foreach ($original as $key => $value) {
				$originalpost["$key"] = "$value";
			}

			$def_post_id = wp_insert_post($originalpost);
		    $def_trid = $sitepress->get_element_trid($def_post_id);

			//get translations post columns for each language
			foreach ($locale as $lang) {
				$inserttranslateddata = $getjson['translations'][$lang];
				
				$post_trans_id = wp_insert_post($inserttranslateddata);

	            //change language and trid of second post to match language and default post trid
	            $sitepress->set_element_language_details($post_trans_id, 'post_post', $def_trid, $lang);
	            
			}

			return true;

		} else {

			return false;
		}
		
	}

	public function updatee(WP_REST_Request $request) {
		//Get id of the post
		$postid = $request->get_url_params();

		$my_post = array();
		$my_post['ID'] = $postid; //add post ID to array
		foreach ($getjson as $key => $value) {
			$my_post[$key] = "$value";
		}

		 return apply_filters( 'wpml_object_id', $postid, 'post', TRUE);
		 
	}

	public function update() {
			    

			    return $languages[1];
	}

	public function delete(WP_REST_Request $request) {
		$postid = $request->get_url_params();
		$id = $postid['id'];
		wp_delete_post( $id );
		return true;
	}


}