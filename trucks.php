<?php
/* Constants */define('BREAKFAST_ID','198');define('LUNCH_ID','212');define('DINNER_ID','213');define('MAIN_DISH','201');
class Trucks {

	public function list_trucks()
	{
		global $wpdb, $table_prefix;		$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";		$trucks = $wpdb->get_results($query);						foreach($trucks as &$truck) {			$src = wp_get_attachment_image_src($truck->truck_image);			$truck->truck_image = !empty($src[0])? $src[0] : '';		}			echo json_encode($trucks);		exit;
	}}
class Trucks_breakfast {	
	public function list_trucks_breakfast()
	{		$truck_id = $_GET['truck_id'];		if($truck_id)		{			global $wpdb, $table_prefix;
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";						$query_truck_foods   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID JOIN `" . $table_prefix . "truck_products` wtp ON wtp.product_id = wtr.object_id  WHERE wtr.term_taxonomy_id ='".BREAKFAST_ID."' AND wpp.post_type='product' AND wtp.truck_id='$truck_id'";						$trucks = $wpdb->get_results($query);
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
										$trucks = (array) $trucks[0];				$foods = $wpdb->get_results($query_truck_foods);						$count = count($foods);				$count_array = $count/3;				$i=0;				foreach($foods as $food) {					if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){						$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));						$content = $xpath->evaluate("string(//img/@src)");  					}else{						$content = '';					}					$food->food_image = $content;					unset($food->post_excerpt);				}						$foods1['food_items'] = $foods;				$res_and_food = array_merge($trucks,$foods1);				$res_and_food1 = (object)$res_and_food;				echo json_encode($res_and_food1);			exit;
		}	}

	

}

class Trucks_lunch {	
	public function list_trucks_lunch()
	{		$truck_id = $_GET['truck_id'];		if($truck_id)		{			global $wpdb, $table_prefix;
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";						$query_truck_foods   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID JOIN `" . $table_prefix . "truck_products` wtp ON wtp.product_id = wtr.object_id  WHERE wtr.term_taxonomy_id ='".LUNCH_ID."' AND wpp.post_type='product' AND wtp.truck_id='$truck_id'";				$trucks = $wpdb->get_results($query);
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
										$trucks = (array) $trucks[0];				$foods = $wpdb->get_results($query_truck_foods);						$count = count($foods);				$count_array = $count/3;				$i=0;				foreach($foods as $food) {					if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){						$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));						$content = $xpath->evaluate("string(//img/@src)");  					}else{						$content = '';					}					$food->food_image = $content;					unset($food->post_excerpt);				}						$foods1['food_items'] = $foods;				$res_and_food = array_merge($trucks,$foods1);				$res_and_food1 = (object)$res_and_food;				echo json_encode($res_and_food1);			exit;
		}	}

	

}

class Trucks_dinner {	
	public function list_trucks_dinner()
	{		$truck_id = $_GET['truck_id'];		if($truck_id)		{			global $wpdb, $table_prefix;
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";						$query_truck_foods   = "SELECT wpp.ID as food_id,wpp.post_title as food_name,wpp.post_excerpt FROM `" . $table_prefix . "posts` wpp JOIN `" . $table_prefix . "term_relationships` wtr ON wtr.object_id = wpp.ID JOIN `" . $table_prefix . "truck_products` wtp ON wtp.product_id = wtr.object_id  WHERE wtr.term_taxonomy_id ='".DINNER_ID."' AND wpp.post_type='product' AND wtp.truck_id='$truck_id'";						$trucks = $wpdb->get_results($query);
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
										$trucks = (array) $trucks[0];				$foods = $wpdb->get_results($query_truck_foods);						$count = count($foods);				$count_array = $count/3;				$i=0;				foreach($foods as $food) {					if(preg_match('/(<img[^>]+>)/i', $food->post_excerpt)){						$xpath = new DOMXPath(@DOMDocument::loadHTML($food->post_excerpt));						$content = $xpath->evaluate("string(//img/@src)");  					}else{						$content = '';					}					$food->food_image = $content;					unset($food->post_excerpt);				}						$foods1['food_items'] = $foods;				$res_and_food = array_merge($trucks,$foods1);				$res_and_food1 = (object)$res_and_food;				echo json_encode($res_and_food1);			exit;
		}	}

	

}
