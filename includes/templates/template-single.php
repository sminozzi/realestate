<?php
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$my_theme =  strtolower(wp_get_theme());
if ($my_theme == 'twenty fourteen')
{
?>
<style type="text/css">
<!--
	.site::before {
    width: 0px !important;
}
-->
</style>
<?php 
}
 get_header();
  ?>
	    <div id="container2">     
            <div id="content2" role="main">
				<?php realestate_realestate_detail();?>
                 <br />
                 <center>
                 <button id="RealEstate_cform">
                 <?php echo __('Contact Us', 'realestate'); ?>
                 </button>
                 </center>
                 <br />
			</div> 
            <?php 
         include_once (REALESTATEPATH . 'includes/contact-form/multi-contact-show-form.php');  
         ?>  
		</div>
<?php 
        $registered_sidebars = wp_get_sidebars_widgets();
        foreach( $registered_sidebars as $sidebar_name => $sidebar_widgets ) {
        	unregister_sidebar( $sidebar_name );
        }
get_footer(); 
?>