<?php /**

 * @author Bill Minozzi

 * @copyright 2017

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function realestate_findglooglemap()

{

 global $wpdb;

        $argsfindfields = array(

            'post_status' => 'publish',

            'post_type' => 'realestatefields'

        );

        query_posts( $argsfindfields );

        $afields = array();

        $afieldsid = array();

        $Mapfield_name = '';

        while ( have_posts() ) : the_post();

            $post_id = esc_attr(get_the_ID());

            $Mapfield_name = get_the_title($post_id);

            $field_type = esc_attr(get_post_meta($post_id, 'field-typefield', true));

            if($field_type  == 'googlemap')

              break;

        endwhile;

        if (!empty ($Mapfield_name) )

           return $isgooglemap = 'product-'.$Mapfield_name;

        else

           return '';

}

 

function realestate_get_fields($type)

{

  global $wpdb;

   if(!function_exists('get_userdata()')) {

    include(ABSPATH . "/wp-includes/pluggable.php");

   }

    if ( $type == 'search')

    {

    $args = array(

            'post_status' => 'publish',

            'post_type' => 'realestatefields',

            'meta_key' => 'field-order',

            'orderby' => 'meta_value_num',

            'order' => 'ASC',

            'meta_query' => array(

            array(

            'key' => 'field-searchbar',

            'value' => '1'

            )

        )

    );

    }

    elseif($type == 'all')

    {

    $args = array(

            'post_status' => 'publish',

            'post_type' => 'realestatefields',

            'meta_key' => 'field-order',

            'orderby' => 'meta_value_num',

            'order' => 'ASC'

        );

    }

    elseif ( $type == 'widget')

    {

    $args = array(

            'post_status' => 'publish',

            'post_type' => 'realestatefields',

            'meta_key' => 'field-order',

            'orderby' => 'meta_value_num',

            'order' => 'ASC',

            'meta_query' => array(

            array(

            'key' => 'field-searchwidget',

            'value' => '1'

            )

        )

    );

    }    

        query_posts( $args );

        $afields = array();

        $afieldsid = array();

        while ( have_posts() ) : the_post();

            $afieldsid[] = esc_attr(get_the_ID());

        endwhile;

         return $afieldsid;  

} // end Funcrions

function realestate_get_meta($post_id)

{

    $fields = array(

        'field-label',

        'field-typefield',

        'field-drop_options',

        'field-searchbar',

        'field-searchwidget',

        'field-rangemin',

        'field-rangemax',

        'field-rangestep',

        'field-slidemin',

        'field-slidemax',

        'field-slidestep',  

        'field-order',

        'field-name');

    $tot = count($fields);

    for ($i = 0; $i < $tot; $i++) {

        $field_value[$i] = esc_attr(get_post_meta($post_id, $fields[$i], true));

    }

    $field_value[$tot-1] = esc_attr(get_the_title($post_id));

    return $field_value;

}

function realestate_get_types()

{

    global $wpdb;

    $productmake = array();  

    $args = array(

        'taxonomy'               => 'agents',

        'orderby'                => 'name',

        'order'                  => 'ASC',

        'hide_empty'             => false,

    );

    $the_query = new WP_Term_Query($args);

    $productmake = array();  

    foreach($the_query->get_terms() as $term){ 

       $productmake[] = $term->name;

    }

 return $productmake; 

}

function realestate_get_max()

{

    global $wpdb;

    $args = array(

        'numberposts' => 1,

        'post_type' => 'products',

        'meta_key' => 'product-price',

        'orderby' => 'meta_value_num',

        'order' => 'DESC');

    $posts = get_posts($args);

    foreach ($posts as $post) {

        $x = get_post_meta($post->ID, 'product-price', true);

        if (!empty($x)) {

            $x = (int)$x;

            if (is_int($x)) {

                $x = ($x) * 1.2;

                $x = round($x, 0, PHP_ROUND_HALF_EVEN);

                //return $x;

            }

        }

        if($x < 1)

          return '100000';

        else

          return $x;

    }

}

add_action( 'wp_loaded', 'realestate_get_types' );

function realestate_currency()

{

    if (get_option('RealEstatecurrency') == 'Dollar') {

        return "$";

    }

    if (get_option('RealEstatecurrency') == 'Pound') {

        return "&pound;";

    }

    if (get_option('RealEstatecurrency') == 'Yen') {

        return "&yen;";

    }

    if (get_option('RealEstatecurrency') == 'Euro') {

        return "&euro;";

    }

    if (get_option('RealEstatecurrency') == 'Universal') {

        return "&curren;";

    }

    if (get_option('RealEstatecurrency') == 'AUD') {

        return "AUD";

    }

    if (get_option('RealEstatecurrency') == 'Real') {

        return "$R";

    }

}

function RealEstate_localization_init_fail()

{

    echo '<div class="error notice">

                     <br />

                     realestatePlugin: Could not load the localization file (Language file).

                     <br />

                     Please, take a look the online Guide item Plugin Setup => Language.

                     <br /><br />

                     </div>';

}

function RealEstate_Show_Notices1()

            {

                    echo '<div class="update-nag notice"><br />';

                    echo 'Warning: Upload directory not found (RealEstate Plugin). Enable debug for more info.';

                    echo '<br /><br /></div>';

            }

function RealEstate_plugin_was_activated()

{

                echo '<div class="updated"><p>';

                $bd_msg = '<img src="'.REALESTATEURL.'assets/images/infox350.png" />';

                $bd_msg .= '<h2>RealEstate Plugin was activated! </h2>';

                $bd_msg .= '<h3>For details and help, take a look at Real Estate Dashboard at your left menu <br />';

                $bd_url = '  <a class="button button-primary" href="admin.php?page=real_estate_plugin">or click here</a>';

                $bd_msg .=  $bd_url;

                echo $bd_msg;

                echo "</p></h3></div>";

     $Multidealerplugin_installed = trim(get_option( 'Multidealerplugin_installed',''));

     if(empty($Multidealerplugin_installed)){

        add_option( 'Multidealerplugin_installed', time() );

        update_option( 'Multidealerplugin_installed', time() );

     }

} 

if( is_admin())

{

   if(get_option('RealEstate_activated', '0') == '1')

   {

     add_action( 'admin_notices', 'RealEstate_plugin_was_activated' );

     $r =  update_option('RealEstate_activated', '0'); 

     if ( ! $r )

        add_option('RealEstate_activated', '0');

   }

} 

if (!function_exists('write_log')) {

    function write_log ( $log )  {

        if ( true === WP_DEBUG ) {

            if ( is_array( $log ) || is_object( $log ) ) {

                error_log( print_r( $log, true ) );

            } else {

                error_log( $log );

            }

        }

    }

}

add_filter( 'plugin_row_meta', 'realestate_custom_plugin_row_meta', 10, 2 );

function realestate_custom_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'realestate.php' ) !== false ) {

		$new_links = array(

				'OnLine Guide' => '<a href="http://realestateplugin.eu/guide/" target="_blank">OnLine Guide</a>',

                                'Pro' => '<a href="http://realestateplugin.eu/premium/" target="_blank"><b><font color="#FF6600">Go Pro</font></b></a>'

				);

		$links = array_merge( $links, $new_links );

	}

	return $links;

}

?>