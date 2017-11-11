<?php /**

 * @author Bill Minozzi

 * @copyright 2017

 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action("template_redirect", 'RealEstate_template_redirect');

function RealEstate_template_redirect()

{

    global $wp;

    global $query;

    global $wp_query;

    if (isset($_GET['RealEstate_search_type'])) {

        $RealEstate_search_type = sanitize_text_field($_GET['RealEstate_search_type']);

            require_once (REALESTATEPATH . 'includes/templates/template-showroom3.php');

        die();

    }

   if (is_single()) {

        $realestateurl = $_SERVER['REQUEST_URI'];

        if (strpos($realestateurl, '/product/') === false)

            return;

        if (isset($wp->query_vars["post_type"])) {

            if ($wp->query_vars["post_type"] == "products") {

                if (have_posts()) {

                    include (REALESTATEPATH . 'includes/templates/template-single.php');

                    die();

                }

            }

        }

    }

}