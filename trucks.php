<?php

class Trucks {

	public function list_trucks()
	{
		global $wpdb, $table_prefix;
	}
class Trucks_breakfast {
	public function list_trucks_breakfast()
	{
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
						
		}

	

}

class Trucks_lunch {
	public function list_trucks_lunch()
	{
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
						
		}

	

}

class Trucks_dinner {
	public function list_trucks_dinner()
	{
			$query   = "SELECT truck_id,truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1 AND truck_id = '8'";
					
			foreach($trucks as &$truck) {
				$src = wp_get_attachment_image_src($truck->truck_image);
				$truck->truck_image = !empty($src[0])? $src[0] : '';
			}
						
		}

	

}