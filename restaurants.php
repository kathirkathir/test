<?php

/* Constants */
define('BREAKFAST_ID','198');
define('LUNCH_ID','212');
define('DINNER_ID','213');
define('MAIN_DISH','201');


class Restaurants {



	public function list_restaurants()

	{

		global $wpdb, $table_prefix;
		
		$query   = "SELECT wpum.user_id,wpum.meta_key,wpum.meta_value FROM `" . $table_prefix . "usermeta` as wpum JOIN " . $table_prefix . "users as wpus ON wpus.ID = wpum.user_id  WHERE wpum.meta_key IN ('pv_shop_name','pv_shop_description','pv_seller_info') AND wpum.user_id IN(SELECT wpum1.user_id FROM " . $table_prefix . "usermeta as wpum1 WHERE wpum1.meta_key ='wp_capabilities' AND wpum1.meta_value LIKE '%vendor%')";
		


		$restaurants = $wpdb->get_results($query);
		$count = count($restaurants);
		$count_array = $count/3;
		$restaurant1 =array();		
		$i=0;
		foreach($restaurants as $restaurant) {
			if($i<$count_array){
				if($restaurant->meta_key == 'pv_shop_name')
					$restaurant->meta_key = 'restaurant_name';			
				if($restaurant->meta_key == 'pv_shop_description')
					$restaurant->meta_key = 'restaurant_description';		
				if($restaurant->meta_key == 'pv_seller_info'){
					$restaurant->meta_key = 'restaurant_info';
					$xpath = new DOMXPath(@DOMDocument::loadHTML($restaurant->meta_value));
					$restaurant1[$i]['restaurant_image'] = $xpath->evaluate("string(//img/@src)");    
				}
				$content = preg_replace("/<img[^>]+\>/i", " ", $restaurant->meta_value); 
				$restaurant1[$i][$restaurant->meta_key] = $content;	
				$restaurant1[$i]['restaurant_id'] = $restaurant->user_id;	
			}
			if(($i+1) == $count_array){
				$i=0;
			}else{
				$i++;
			}
			//$src = wp_get_attachment_image_src($restaurant->truck_image);
			//$restaurant->restaurant_image = !empty($src[0])? $src[0] : '';

		}
		
		echo json_encode($restaurant1);

		exit;

	}


}

class Foods_breakfast {



	public function list_foods_for_restaurants()
	{

		$id = $_GET['res_id'];
		if($id){
			global $wpdb, $table_prefix;
			
			$query   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID WHERE wtr.term_taxonomy_id ='".BREAKFAST_ID."' AND wpp.post_type='product' AND wpp.post_author='$id'  ";
			
			$query_res   = "SELECT wpum.user_id,wpum.meta_key,wpum.meta_value FROM `" . $table_prefix . "usermeta` as wpum WHERE wpum.meta_key IN ('pv_shop_name','pv_shop_description','pv_seller_info') AND wpum.user_id ='$id'";
			$restaurants = $wpdb->get_results($query_res);
			$restaurant1 = array();
			foreach($restaurants as $restaurant) {
					if($restaurant->meta_key == 'pv_shop_name')
						$restaurant->meta_key = 'restaurant_name';			
					if($restaurant->meta_key == 'pv_shop_description')
						$restaurant->meta_key = 'restaurant_description';		
					if($restaurant->meta_key == 'pv_seller_info'){
						$restaurant->meta_key = 'restaurant_info';
						$xpath = new DOMXPath(@DOMDocument::loadHTML($restaurant->meta_value));
						$restaurant1['restaurant_image'] = $xpath->evaluate("string(//img/@src)");    
					}
					$content = preg_replace("/<img[^>]+\>/i", " ", $restaurant->meta_value); 
					$restaurant1[$restaurant->meta_key] = $content;	
					$restaurant1['restaurant_id'] = $restaurant->user_id;	

			}
			$restaurant2 = $restaurant1;
			
			$foods = $wpdb->get_results($query);		
			$count = count($foods);
			$count_array = $count/3;
			$i=0;
			foreach($foods as $food) {
				if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){
					$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));
					$content = $xpath->evaluate("string(//img/@src)");  
				}else{
					$content = '';
				}
				$food->food_image = $content;
				unset($food->post_excerpt);
			}
			//echo "<pre>";print_r($foods);die;
					$foods1['food_items'] = $foods;

			$res_and_food = array_merge($restaurant2,$foods1);
			$res_and_food1 = (object)$res_and_food;
			echo json_encode($res_and_food1);
			exit;

		}
	
	}

	
	
}

			


class Foods_lunch {

		
	public function list_foods_for_restaurants_lunch()
	{

		$id = $_GET['res_id'];
		if($id){
			global $wpdb, $table_prefix;
			
			$query   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID WHERE wtr.term_taxonomy_id  ='".LUNCH_ID."' AND wpp.post_type='product' AND wpp.post_author='$id'  ";
			
			$query_res   = "SELECT wpum.user_id,wpum.meta_key,wpum.meta_value FROM `" . $table_prefix . "usermeta` as wpum WHERE wpum.meta_key IN ('pv_shop_name','pv_shop_description','pv_seller_info') AND wpum.user_id ='$id'";
			$restaurants = $wpdb->get_results($query_res);
			$restaurant1 = array();
			foreach($restaurants as $restaurant) {
					if($restaurant->meta_key == 'pv_shop_name')
						$restaurant->meta_key = 'restaurant_name';			
					if($restaurant->meta_key == 'pv_shop_description')
						$restaurant->meta_key = 'restaurant_description';		
					if($restaurant->meta_key == 'pv_seller_info'){
						$restaurant->meta_key = 'restaurant_info';
						$xpath = new DOMXPath(@DOMDocument::loadHTML($restaurant->meta_value));
						$restaurant1['restaurant_image'] = $xpath->evaluate("string(//img/@src)");    
					}
					$content = preg_replace("/<img[^>]+\>/i", " ", $restaurant->meta_value); 
					$restaurant1[$restaurant->meta_key] = $content;	
					$restaurant1['restaurant_id'] = $restaurant->user_id;	

			}
			$restaurant2 = $restaurant1;
			
			$foods = $wpdb->get_results($query);		
			$count = count($foods);
			$count_array = $count/3;
			$i=0;
			foreach($foods as $food) {
				if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){
					$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));
					$content = $xpath->evaluate("string(//img/@src)");  
				}else{
					$content = '';
				}
				$food->food_image = $content;
				unset($food->post_excerpt);
			}
					$foods1['food_items'] = $foods;

			$res_and_food = array_merge($restaurant2,$foods1);
			$res_and_food1 = (object)$res_and_food;
			echo json_encode($res_and_food1);
			exit;

		}
	
	}			

}




class Foods_dinner {

	
	public function list_foods_for_restaurants_dinner()
	{

		$id = $_GET['res_id'];
		if($id){
			global $wpdb, $table_prefix;
			
			$query   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID WHERE wtr.term_taxonomy_id ='".DINNER_ID."' AND wpp.post_type='product' AND wpp.post_author='$id'  ";
				
			$query_res   = "SELECT wpum.user_id,wpum.meta_key,wpum.meta_value FROM `" . $table_prefix . "usermeta` as wpum WHERE wpum.meta_key IN ('pv_shop_name','pv_shop_description','pv_seller_info') AND wpum.user_id ='$id'";
			$restaurants = $wpdb->get_results($query_res);
			$restaurant1 = array();
			foreach($restaurants as $restaurant) {
					if($restaurant->meta_key == 'pv_shop_name')
						$restaurant->meta_key = 'restaurant_name';			
					if($restaurant->meta_key == 'pv_shop_description')
						$restaurant->meta_key = 'restaurant_description';		
					if($restaurant->meta_key == 'pv_seller_info'){
						$restaurant->meta_key = 'restaurant_info';
						$xpath = new DOMXPath(@DOMDocument::loadHTML($restaurant->meta_value));
						$restaurant1['restaurant_image'] = $xpath->evaluate("string(//img/@src)");    
					}
					$content = preg_replace("/<img[^>]+\>/i", " ", $restaurant->meta_value); 
					$restaurant1[$restaurant->meta_key] = $content;	
					$restaurant1['restaurant_id'] = $restaurant->user_id;	

			}
			$restaurant2 = $restaurant1;
			
			$foods = $wpdb->get_results($query);		
			$count = count($foods);
			$count_array = $count/3;
			$i=0;
			foreach($foods as $food) {
				if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){
					$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));
					$content = $xpath->evaluate("string(//img/@src)");  
				}else{
					$content = '';
				}
				$food->food_image = $content;
				unset($food->post_excerpt);
			}
					$foods1['food_items'] = $foods;

			$res_and_food = array_merge($restaurant2,$foods1);
			$res_and_food1 = (object)$res_and_food;
			echo json_encode($res_and_food1);
			exit;

		}
	
	}

			

}

class Foods_maindish {

	
	public function list_foods_for_restaurants_maindish()
	{

		$id = $_GET['res_id'];
		if($id){
			global $wpdb, $table_prefix;
			
			$query   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID WHERE wtr.term_taxonomy_id ='".MAIN_DISH."' AND wpp.post_type='product' AND wpp.post_author='$id'  ";
			
			$query_res   = "SELECT wpum.user_id,wpum.meta_key,wpum.meta_value FROM `" . $table_prefix . "usermeta` as wpum WHERE wpum.meta_key IN ('pv_shop_name','pv_shop_description','pv_seller_info') AND wpum.user_id ='$id'";
			$restaurants = $wpdb->get_results($query_res);
			$restaurant1 = array();
			foreach($restaurants as $restaurant) {
					if($restaurant->meta_key == 'pv_shop_name')
						$restaurant->meta_key = 'restaurant_name';			
					if($restaurant->meta_key == 'pv_shop_description')
						$restaurant->meta_key = 'restaurant_description';		
					if($restaurant->meta_key == 'pv_seller_info'){
						$restaurant->meta_key = 'restaurant_info';
						$xpath = new DOMXPath(@DOMDocument::loadHTML($restaurant->meta_value));
						$restaurant1['restaurant_image'] = $xpath->evaluate("string(//img/@src)");    
					}
					$content = preg_replace("/<img[^>]+\>/i", " ", $restaurant->meta_value); 
					$restaurant1[$restaurant->meta_key] = $content;	
					$restaurant1['restaurant_id'] = $restaurant->user_id;	

			}
			$restaurant2 = $restaurant1;
			
			$foods = $wpdb->get_results($query);		
			$count = count($foods);
			$count_array = $count/3;
			$i=0;
			foreach($foods as $food) {
				if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){
					$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));
					$content = $xpath->evaluate("string(//img/@src)");  
				}else{
					$content = '';
				}
				$food->food_image = $content;
				unset($food->post_excerpt);
			}
					$foods1['food_items'] = $foods;

			$res_and_food = array_merge($restaurant2,$foods1);
			$res_and_food1 = (object)$res_and_food;
			echo json_encode($res_and_food1);
			exit;

		}
	
	}

			

}

?>