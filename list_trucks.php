<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class List_Trucks extends WP_List_Table
{
    function __construct()
    {
        global $status, $page;
        //Set parent defaults
        parent::__construct(array(
            'singular' => 'Truck', //singular name of the listed records
            'plural' => 'Trucks', //plural name of the listed records
            'ajax' => false //does this table support ajax?
        ));
    }
    function column_default($item, $column_name)
    {
    }
    function column_title($item)
    {
        //Build row actions
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&p=%s">Edit</a>', sanitize_text_field($_REQUEST['page']), 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&p=%s">Delete</a>', sanitize_text_field($_REQUEST['page']), 'delete', $item['id'])
        );
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s', /*$1%s*/ $item['pincode'], /*$2%s*/ $item['id'], /*$3%s*/ $this->row_actions($actions));
    }
    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="%1$s[]" value="%2$s" />', /*$1%s*/ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID'] //The value of the checkbox should be the record's id
            );
    }
    function get_columns()
    {
        $columns = array(
            'truck_id' => '<label for="id-select-all-1" class="screen-reader-text">Select All</label><input class="id-select-all-1" type="checkbox" />', //Render a checkbox instead of text
            'truck_image' => 'Truck Image',
			'truck_name' => 'Truck Name',
            'truck_no' => 'Truck No',
            'truck_phone' => 'Phone',
            'truck_status' => 'Status',
			'manage_products' => 'Add/Remove Products'
        );
        return $columns;
    }
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'truck_name' => array(
                'truck_name',
                false
            ), //true means it's already sorted
            'truck_no' => array(
                'truck_no',
                false
            ),
            'truck_status' => array(
                'truck_status',
                false
            )
        );
        return $sortable_columns;
    }
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete',
			'active' => 'Active',
			'inactive' => 'Inactive'
        );
        return $actions;
    }
    function process_bulk_action()
    {
        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
    }
    function prepare_items()
    {
        global $wpdb, $_wp_column_headers, $table_prefix;
        /* -- Preparing your query -- */
        $query   = "SELECT * FROM `" . $table_prefix . "trucks`";
        /* -- Ordering parameters -- */
        //Parameters that are going to be used to order the result
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
        $order   = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        if (!empty($orderby) & !empty($order)) {
            $query .= ' ORDER BY ' . $orderby . ' ' . $order;
        }
        /* -- Pagination parameters -- */
        //Number of elements in your table?
        $totalitems = $wpdb->query($query); //return the total number of affected rows
        //How many to display per page?
        $perpage    = 15;
        //Which page is this?
        $paged      = !empty($_GET["paged"]) ? $_GET["paged"] : '';
        //Page Number
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        //How many pages do we have in total?
        $totalpages = ceil($totalitems / $perpage);
        //adjust the query to take pagination into account
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= ' LIMIT ' . (int) $offset . ',' . (int) $perpage;
        }
        /* -- Register the pagination -- */
        $this->set_pagination_args(array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage
        ));
        //The pagination links are automatically built according to those parameters
        /* -- Register the Columns -- */
        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array(
            $columns,
            $hidden,
            $sortable
        );
        /* -- Fetch the items -- */
        $this->items           = $wpdb->get_results($query);
    }
    function display_rows()
    {
        //Get the records registered in the prepare_items method
        $records = $this->items;
        //Get the columns registered in the get_columns and get_sortable_columns methods
        list($columns, $hidden) = $this->get_column_info();
        //Loop for each record
        if (!empty($records)) {
            foreach ($records as $rec) {
                //Open the line
                echo '<tr class="alternate" id="record_' . $rec->truck_id . '">';
                foreach ($columns as $column_name => $column_display_name) {
                    //Style attributes for each col
                    $class = "class='$column_name column-$column_name'";
                    $style = "";
                    if (in_array($column_name, $hidden))
                        $style = ' style="display:none;"';
                    $attributes = $class . $style;
                    //edit link
                    $editlink   = '/wp-admin/link.php?action=edit&id=' . stripslashes($rec->truck_id);
                    //Display the cell
                    switch ($column_name) {
                        case "truck_id":
                            echo '<th ' . $attributes . '><input name="truck_id[]" type="checkbox" value="' . stripslashes($rec->truck_id) . '" /></th>';
                            break;
						case "truck_image":
							$image = '';
                            if($rec->truck_image) {
								$src = wp_get_attachment_image_src($rec->truck_image);
								$image = '<img src="'.$src[0].'" width="40">';
							}
							echo '<td ' . $attributes . '>'. $image .'</td>';
                            break;
                        case "truck_name":
                            echo '<td ' . $attributes . '><a href="?page=add_truck&amp;action=edit&amp;id=' . stripslashes($rec->truck_id) . '"><b>' . stripslashes($rec->truck_name) . '</b></a><div class="row-actions"><span class="edit"><a href="?page=add_truck&amp;action=edit&amp;id=' . stripslashes($rec->truck_id) . '">Edit</a> | </span><span class="delete"><a href="?page=list_trucks&amp;action=delete&amp;id=' . stripslashes($rec->truck_id) . '">Delete</a></span></div></td>';
                            break;
                        case "truck_no":
                            echo '<td ' . $attributes . '>' . stripslashes($rec->truck_no) . '</td>';
                            break;
                        case "truck_phone":
                            echo '<td ' . $attributes . '>' . stripslashes($rec->truck_phone) . '</td>';
                            break;
                        case "truck_status":
							$status = $rec->truck_status? 'Active' : 'Inactive';
                            echo '<td ' . $attributes . '>' . $status . '</td>';
                            break;
						case "manage_products":							
                            echo '<td ' . $attributes . '><a href="?page=assign_products&amp;truck_id=' . stripslashes($rec->truck_id) . '">Manage</a></td>';
                            break;
                    }
                }
                //Close the line
                echo '</tr>';
            }
        }
    }
}

global $table_prefix, $wpdb;

$user_id = get_current_user_id();
$ListTrucks = new List_Trucks();

$action = $ListTrucks->current_action();

if ($action == 'delete') {
    $id = intval($_GET['id']);
    if (isset($id)) {
        $wpdb->query($wpdb->prepare("DELETE FROM `" . $table_prefix . "trucks` WHERE `truck_id` = %d AND `vendor_id` = %d ", $id, $user_id));
    }
    $ids = $_GET['truck_id'];
    if (isset($ids)) {
        $count = count($ids);
        for ($i = 0; $i < $count; $i++) {
            $_id = $ids[$i];
            $wpdb->query($wpdb->prepare("DELETE FROM `" . $table_prefix . "trucks` WHERE `truck_id` = %d AND `vendor_id` = %d ", $_id, $user_id));
        }
    }
}

else if ($action == 'active') {
    
    $ids = $_GET['truck_id'];
    if (isset($ids)) {
        $count = count($ids);
        for ($i = 0; $i < $count; $i++) {
            $_id = $ids[$i];
            $wpdb->query($wpdb->prepare("UPDATE `" . $table_prefix . "trucks` SET truck_status = 1 WHERE `truck_id` = %d AND `vendor_id` = %d ", $_id, $user_id));
        }
    }
}

else if ($action == 'inactive') {
    
    $ids = $_GET['truck_id'];
    if (isset($ids)) {
        $count = count($ids);
        for ($i = 0; $i < $count; $i++) {
            $_id = $ids[$i];
            $wpdb->query($wpdb->prepare("UPDATE `" . $table_prefix . "trucks` SET truck_status = 0 WHERE `truck_id` = %d AND `vendor_id` = %d ", $_id, $user_id));
        }
    }
}

//Fetch, prepare, sort, and filter our data...
$ListTrucks->prepare_items();

    
?>

<div class="wrap">
    
<?php if ($action == 'delete') { ?>
    <div class="updated below-h2" id="message">
    	<p>Deleted Successfully.</p>
    </div>
<?php  } else if ($action == 'active') {?>
	<div class="updated below-h2" id="message">
    	<p>Activated Successfully.</p>
  	</div>
<?php  } else if ($action == 'inactive') {?>
	<div class="updated below-h2" id="message">
    	<p>Inactivated Successfully.</p>
  	</div>
<?php  } ?>
  
  <div id="icon-users" class="icon32"><br/>
  </div>
  <h2>Trucks List <a class="add-new-h2" href="?page=add_truck">Add New</a></h2>
  
  <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
  
  <form id="pincodes-filter" method="get">
    
    <!-- For plugins, we also need to ensure that the form posts back to our current page -->
    
    <input type="hidden" name="page" value="<?php
            echo sanitize_text_field($_REQUEST['page']);
?>" />
    
    <!-- Now we can render the completed list table -->
    
    <?php
            $ListTrucks->display();
	?>
  </form>

</div>
<script>

	jQuery('.id-select-all-1').click(function() {

		if (jQuery(this).is(':checked')) {

			jQuery('div input').attr('checked', true);

		} else {

			jQuery('div input').attr('checked', false);

		}

	});

</script>