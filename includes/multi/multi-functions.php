<?php add_action('init', 'realestateAddFieldsPost');
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function realestateAddFieldsPost() {
	register_post_type( 'realestatefields', 
		array( 
			'labels' => array(
				'name' => 'Fields',
				'all_items' => 'Fields Table',
				'singular_name' => 'Fields',
				'add_new_item' => 'Add Fields',
				'edit_item' => 'Edit Fields',
				'search_items' => 'Search Fields',
				'not_found' => 'No Fields Found',
				'not_found_in_trash' => 'No Fields Found in Trash',
				'menu_name' => 'Real Estate'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
             'show_in_menu' => false, //'multi-dealer',
			'exclude_from_search' => false,
			'rewrite' => array("slug" => "realestatefields"),
		)
	);
};
function RealEstate_fields_columns_head($defaults) {
    $defaults['field-order'] = 'Order';
    $defaults['field-typefield'] = 'Type Field';
    $defaults['field-label'] = 'Label';
    $defaults['field-searchbar'] = 'Search Bar';
    $defaults['field-searchwidget'] = 'Widget';
    return $defaults;
}
function RealEstate_fields_columns_content($column_name, $post_ID) {
    if ($column_name == 'field-order'){
         echo get_post_meta( $post_ID, 'field-order', true ); 
    }  
    if ($column_name == 'field-typefield'){
         echo get_post_meta( $post_ID, 'field-typefield', true ); 
    }
    elseif ($column_name == 'field-label'){
         echo get_post_meta( $post_ID, 'field-label', true ); 
    }
    elseif ($column_name == 'field-searchbar'){
            if(get_post_meta( $post_ID, 'field-searchbar', true ) == '1')
             echo 'Ok';
            else
             echo 'No';
    }
    elseif ($column_name == 'field-searchwidget'){
        if(get_post_meta( $post_ID, 'field-searchwidget', true ) == '1')
             echo 'Ok';
            else
             echo 'No';      
        }
}
add_filter( 'manage_edit-realestatefields_sortable_columns', 'realestate_fields_sortable_column' );
function realestate_fields_sortable_column( $columns ) {
    $columns['field-label'] = 'Label';
    $columns['field-searchwidget'] = 'Widget';
    $columns['field-typefield'] = 'Type Field';
    $columns['field-searchbar'] = 'Search Bar';
    $columns['field-order'] = 'Order';   
    return $columns;
}
function realestate_multifields_list($query) {
    if( is_admin()) {
        return;
    }
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', "field-order");
        $query->set('order', 'ASC');
}
if(isset($_GET['post_type'])){
    if ($_GET['post_type'] == 'realestatefields')
      {
        // add_action('pre_get_posts', 'realestate_multifields_list');
        add_filter('manage_realestatefields_posts_columns', 'RealEstate_fields_columns_head');
        add_action('manage_realestatefields_posts_custom_column', 'RealEstate_fields_columns_content', 10, 2);
     }
}