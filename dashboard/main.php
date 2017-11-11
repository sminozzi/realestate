<?php 

/**

 * @author William Sergio Minozzi

 * @copyright 2017

 */
 
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
    

// ob_start();

add_action( 'admin_init', 'realestate_settings_init' );

add_action( 'admin_menu', 'realestate_add_admin_menu' );

function realestate_enqueue_scripts() {

      	wp_enqueue_style( 'bill-help' , REALESTATEURL.'/dashboard/css/help.css');

}

add_action('admin_init', 'realestate_enqueue_scripts');

 function realestate_fields_callback() {

    ?>

    <script type="text/javascript">

    <!--

     window.location  = "/wp-admin/edit.php?post_type=realestatefields";

    -->

</script>

<?php

}

 function realestate_products_callback() {

    ?>

    <script type="text/javascript">

    <!--

     window.location  = "/wp-admin/edit.php?post_type=products";

    -->

</script>

<?php

}

function realestate_agents_callback() {

    ?>

    <script type="text/javascript">

    <!--

     window.location  = "/wp-admin/edit-tags.php?taxonomy=agents&post_type=products";

    -->

</script>

<?php

 }

function realestate_locations_callback() {

    ?>

    <script type="text/javascript">

    <!--

     window.location  = "/wp-admin/edit-tags.php?taxonomy=locations&post_type=products";

    -->

</script>

<?php

 }

function settings_callback() {

    ?>

    <script type="text/javascript">

    <!--

     window.location  = "/wp-admin/options.php?page=md_settings";

    -->

</script>

<?php

 }

function realestate_add_admin_menu(  ) {

 //   global $vmtheme_hook;

 //   $vmtheme_hook = add_theme_page( 'For Dummies', 'For Dummies Help', 'manage_options', 'for_dummies', 'realestate_options_page' );

 //   add_action('load-'.$vmtheme_hook, 'vmtheme_contextual_help');     

    Global $menu;

    add_menu_page(

    'Real Estate', 

    'Real Estate', 

    'manage_options', 

    'real_estate_plugin',

    'realestate_options_page', 

    REALESTATEURL.'assets/images/home_icon.png' , 

    '30' );

 include_once(ABSPATH . 'wp-includes/pluggable.php');

$link_our_new_CPT = urlencode('edit.php?post_type=realestatefields');

   add_submenu_page('real_estate_plugin', 'Fields Table', 'Fields Table', 'manage_options', 'fields-table', 'realestate_fields_callback');

   add_submenu_page('real_estate_plugin', 'Properties Table', 'Properties Table', 'manage_options', 'products-table', 'realestate_products_callback');

   add_submenu_page('real_estate_plugin', 'Agents', 'Agents', 'manage_options', 'md-agents', 'realestate_agents_callback');

   add_submenu_page('real_estate_plugin', 'Locations', 'Locations', 'manage_options', 'md-locations', 'realestate_locations_callback');

   add_submenu_page('real_estate_plugin', 'Settings', 'Settings', 'manage_options', 'md-settings', 'settings_callback');

}

function realestate_settings_init(  ) { 

	register_setting( 'realestate', 'realestate_settings' );

}

function realestate_options_page(  ) { 

    global $activated, $realestate_update_theme;

            $wpversion = get_bloginfo('version');

            $current_user = wp_get_current_user();

            $plugin = plugin_basename(__FILE__); 

            $email = $current_user->user_email;

            $username =  trim($current_user->user_firstname);

            $user = $current_user->user_login;

            $user_display = trim($current_user->display_name);

            if(empty($username))

               $username = $user;

            if(empty($username))

               $username = $user_display;

            $theme = wp_get_theme( );

            $themeversion = $theme->version ; 

            $memory['limit'] = (int) ini_get('memory_limit') ;	

            $memory['usage'] = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 0) : 0;

            $memory['wplimit'] =  WP_MEMORY_LIMIT ;

  ?>

    <!-- Begin Page -->

<div id = "realestate-theme-help-wrapper">   

     <div id="realestate-not-activated"></div>

     <div id="realestate-logo">

       <img alt="logo" src="<?php echo REALESTATEIMAGES;?>logosmall.png" />

     </div>

     <div id="realestate_help_title">

         Help and Support Page

     </div> 

 <?php

if( isset( $_GET[ 'tab' ] ) ) 

    $active_tab = strip_tags($_GET[ 'tab' ]);

else

   $active_tab = 'dashboard';

?>

    <h2 class="nav-tab-wrapper">

    <a href="?page=real_estate_plugin&tab=memory&tab=dashboard" class="nav-tab">Dashboard</a>

    <a href="?page=real_estate_plugin&tab=memory" class="nav-tab">Memory Check Up</a>

    </h2>

<?php  

if($active_tab == 'memory') {     

   require_once (REALESTATEPATH . 'dashboard/memory.php');

} 

else

{ 

    require_once (REALESTATEPATH . 'dashboard/dashboard.php');

}

 echo '</div> <!-- "realestate-theme_help-wrapper"> -->';

} // end Function realestate_options_page

     require_once(ABSPATH . 'wp-admin/includes/screen.php');

// ob_end_clean();

 include_once(ABSPATH . 'wp-includes/pluggable.php');

?>