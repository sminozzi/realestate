<?php 
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('init', 'realestatePosts');
function realestatePosts () {
	register_post_type( 'products', 
		array( 
			'labels' => array(
				'name' => 'Products',
				'all_items' => 'All Properties',
				'singular_name' => 'Property',
				'add_new_item' => 'Add Property',
				'edit_item' => 'Edit Property',
				'search_items' => 'Search Properties',
				'view_item' => 'View Property',
				'not_found' => 'No Properties Found',
				'not_found_in_trash' => 'No Properties Found in Trash'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'has_archive' => true,
			'show_in_menu' => false,
			'supports' => array (
				'title',
				'page-attributes',
				'editor',
				'thumbnail',
			),
			'taxonomies' => array( 'agents',
				'agents',
                'locations',
			),
			'exclude_from_search' => false,
			'_builtin' => false,
			'hierarchical' => false,
			'rewrite' => array("slug" => "product"),
		)
	);
};
add_action('init', 'RealEstate_taxonomies');
function RealEstate_taxonomies() { 
register_taxonomy( 'agents', 'products', array(
			'labels' => array(
				'name' => 'agents',
				'singular_name' => 'agents',
				'search_items' => 'Search agents',
				'popular_items' => 'Popular agents',
				'all_items' => 'All agents',
				'parent_item' => __( 'Parent agents', 'realestate' ),
  				'parent_item_colon' => __( 'Parent agents:' ),
				'edit_item' => __( 'Edit agents', 'realestate' ), 
				'update_item' => __( 'Update agents', 'realestate' ),
				'add_new_item' => __( 'Add New agents', 'realestate' ),
				'new_item_name' => __( 'New agents' , 'realestate'),
				'separate_items_with_commas' => __( 'Separate agents with commas', 'realestate' ),
				'add_or_remove_items' => __( 'Add or Remove agents' , 'realestate'),
				'choose_from_most_used' => __( 'Choose from the most used makers', 'realestate' ),
				'menu_name' => 'Agents',
			),
			'hierarchical' => true,
			'show_ui' => true, // Hide from menu
			'query_var' => true,
			'rewrite' => array( 'slug' => 'agents' ),
			'public' => true,
		)
	);
   register_taxonomy( 'locations', 'products', array(
			'labels' => array(
				// 'name' => _x('locations', 'taxonomy general name', 'realestate'),
				'name' => 'locations',
				'singular_name' => 'locations',
				'search_items' => 'Search locations',
				'popular_items' => 'Popular locations',
				'all_items' => 'All locations',
				'parent_item' => __( 'Parent locations', 'realestate' ),
  				'parent_item_colon' => __( 'Parent locations:' ),
				'edit_item' => __( 'Edit locations', 'realestate' ), 
				'update_item' => __( 'Update locations', 'realestate' ),
				'add_new_item' => __( 'Add New locations', 'realestate' ),
				'new_item_name' => __( 'New locations' , 'realestate'),
				'separate_items_with_commas' => __( 'Separate locations with commas', 'realestate' ),
				'add_or_remove_items' => __( 'Add or Remove locations' , 'realestate'),
				'choose_from_most_used' => __( 'Choose from the most used locations', 'realestate' ),
				'menu_name' => 'Locations',
			),
			'hierarchical' => true,
			'show_ui' => true, // hide from menu
			'query_var' => true,
			'rewrite' => array( 'slug' => 'agents' ),
			'public' => true,
		)
	);
}
function realestate_custom_listing_save_data($post_id) {
    global $meta_box,  $post;
    if( isset($_POST['listing_meta_box_nonce']))
    {
        if (!wp_verify_nonce($_POST['listing_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ( isset($_POST['post_type']))
     { 
        if ('page' == sanitize_text_field($_POST['post_type'])) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }
}
add_action('save_post', 'realestate_custom_listing_save_data');
add_image_size('featured_preview', 55, 55, true);
 // GET FEATURED IMAGE
function RealEstate_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}
// ADD NEW COLUMN
add_action('admin_head', 'RealEstate_my_admin_custom_styles');
function RealEstate_my_admin_custom_styles() {
    $output_css = '<style type="text/css">
        .featured_image { width:150px !important; overflow:hidden }
    </style>';
    echo $output_css;
}
function RealEstate_columns_head($defaults) {
    $defaults['product-price'] = 'Price';
    $defaults['featured_image'] = __('Featured Image');
    $defaults['product-featured'] = 'Featured';
    $defaults['product-year'] = 'Year';
    return $defaults;
}
// SHOW THE FEATURED IMAGE
function RealEstate_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = RealEstate_get_featured_image($post_ID);
 		$image_id = get_post_thumbnail_id($post_ID);
		$image_url = wp_get_attachment_image_src($image_id,'medium', true);	
		$image = str_replace("-".$image_url[1]."x".$image_url[2], "", $image_url[0]);
        $thumb = RealEstate_theme_thumb($image, 150, 75, 'br'); // Crops from bottom right
        if ($post_featured_image) {
            echo '<img src="' . $thumb . '" width="150px" height="75px" />';
        }
        else
          {
            echo '<img src="'.REALESTATEURL.'assets/images/image-no-available.jpg" width="100px" />';}
    }
    elseif ($column_name == 'product-year'){
         echo get_post_meta( $post_ID, 'product-year', true ); 
    }
    elseif ($column_name == 'product-price'){
         $price = get_post_meta( $post_ID, 'product-price', true );
         if(! empty($price)) 
            echo  realestate_currency() . $price ; 
         else
            echo  __('Call For Price', 'realestate', 'realestate');
    }
    elseif ($column_name == 'product-featured'){
         $r = get_post_meta( $post_ID, 'product-featured', true ); 
         if($r == 'enabled')
           {echo 'Yes';}
         else
           {echo 'No';}
    }
}
if(isset($_GET['post_type'])){
    if ($_GET['post_type'] == 'products')
      {
        add_filter('manage_posts_columns', 'RealEstate_columns_head');
        add_action('manage_posts_custom_column', 'RealEstate_columns_content', 10, 2);
      }
  }