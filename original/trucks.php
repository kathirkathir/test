<?php

class Trucks {

	public function list_trucks()
	{
		global $wpdb, $table_prefix;
		$query   = "SELECT truck_name, truck_no, truck_phone, truck_image, lat, `long` FROM `" . $table_prefix . "trucks` WHERE truck_status = 1";
		//$query .= ' ORDER BY ' . $orderby . ' ' . $order;	
		$trucks = $wpdb->get_results($query);
				
		foreach($trucks as &$truck) {
			$src = wp_get_attachment_image_src($truck->truck_image);
			$truck->truck_image = !empty($src[0])? $src[0] : '';
		}
		echo json_encode($trucks);
		exit;
	}

	

}
