<?php /*
Plugin Name: Real Estate Right Now 
Plugin URI: http://realestateplugin.eu
Description: Released: Nov/17. Manage, list and sell Real Estate properties. Slider Price Range, configurable search box and more.
Version: 1.1
Text Domain: realestate
Domain Path: /language
Author: Bill Minozzi
Author URI: http://billminozzi.com
License:     GPL2
Copyright (c) 2017 Bill Minozzi
Real Estate Right Away is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
realestate is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with realestate. If not, see {License URI}.
Permission is hereby granted, free of charge subject to the following conditions:
The above copyright notice and this FULL permission notice shall be included in
all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
*/
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
define('REALESTATEVERSION', '1.1');
define('REALESTATEPATH', plugin_dir_path(__file__));
define('REALESTATEURL', plugin_dir_url(__file__));
define('REALESTATEIMAGES', plugin_dir_url(__file__) . 'assets/images/');
include_once (ABSPATH . 'wp-includes/pluggable.php');
function realestate_plugin_settings_link($links)
{
    $settings_link = '<a href="options.php?page=md_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__file__);
if (is_admin()) {
    $path = dirname(plugin_basename(__file__)) . '/language/';
    $loaded = load_plugin_textdomain('realestate', false, $path);
    if (!$loaded and get_locale() <> 'en_US') {
        if (function_exists('RealEstate_localization_init_fail'))
            add_action('admin_notices', 'RealEstate_localization_init_fail');
    }
} else {
    add_action('plugins_loaded', 'RealEstate_localization_init');
}
add_filter("plugin_action_links_$plugin", 'realestate_plugin_settings_link');
require_once (REALESTATEPATH . "settings/load-plugin.php");
require_once (REALESTATEPATH . "settings/options/plugin_options_tabbed.php");
require_once (REALESTATEPATH . 'includes/contact-form/multi-contact-form.php');
require_once (REALESTATEPATH . 'includes/help/help.php');
require_once (REALESTATEPATH . 'includes/functions/functions.php');
require_once (REALESTATEPATH . 'includes/post-type/meta-box.php');
require_once (REALESTATEPATH . 'includes/post-type/post-functions.php');
require_once (REALESTATEPATH . 'includes/templates/template-functions.php');
require_once (REALESTATEPATH . 'includes/templates/redirect.php');
require_once (REALESTATEPATH . 'includes/widgets/widgets.php');
require_once (REALESTATEPATH . 'includes/search/search-function.php');
require_once (REALESTATEPATH . 'includes/multi/multi.php');
require_once (REALESTATEPATH . 'dashboard/main.php');
$Multidealer_template_gallery = trim(get_option('RealEstate_template_gallery',
    'yes'));
require_once (REALESTATEPATH . 'includes/templates/template-showroom1.php');
require_once (REALESTATEPATH . 'includes/multi/multi-functions.php');
$realestateurl = $_SERVER['REQUEST_URI'];
if (strpos($realestateurl, 'product') !== false) {
    $RealEstate_overwrite_gallery = strtolower(get_option('RealEstate_overwrite_gallery',
        'yes'));
    if ($RealEstate_overwrite_gallery == 'yes')
        require_once (REALESTATEPATH . 'includes/gallery/gallery.php');
}
add_action('wp_enqueue_scripts', 'RealEstate_add_files');
function RealEstate_add_files()
{
    wp_enqueue_style('show-room', REALESTATEURL . 'includes/templates/show-room.css');
    wp_enqueue_style('pluginStyleGeneral', REALESTATEURL .
        'includes/templates/template-style.css');
    wp_enqueue_style('pluginStyleSearch2', REALESTATEURL .
        'includes/search/style-search-box.css');
    wp_enqueue_style('pluginStyleSearchwidget', REALESTATEURL .
        'includes/widgets/style-search-widget.css');
    wp_enqueue_style('pluginStyleGeneral4', REALESTATEURL .
        'includes/gallery/css/flexslider.css');
    wp_enqueue_style('pluginStyleGeneral5', REALESTATEURL .
        'includes/contact-form/css/multi-contact-form.css');
    wp_register_style('jqueryuiSkin', REALESTATEURL . 'assets/jquery/jqueryui.css',
        array(), '1.12.1');
    wp_enqueue_style('jqueryuiSkin');
    wp_enqueue_script('jquery-ui-slider');
}
function RealEstate_activated()
{
    $w = update_option('RealEstate_activated', '1');
    if (!$w)
        add_option('RealEstate_activated', '1');
    $admin_email = get_option('admin_email');
    $old_admin_email = trim(get_option('RealEstate_recipientEmail', ''));
    if (empty($old_admin_email)) {
        $w = update_option('RealEstate_recipientEmail', $admin_email);
        if (!$w)
            add_option('RealEstate_recipientEmail', $admin_email);
    }
}
register_activation_hook(__file__, 'RealEstate_activated');
function RealEstate_localization_init()
{
    $path = dirname(plugin_basename(__file__)) . '/language/';
    $loaded = load_plugin_textdomain('realestate', false, $path);
}
function realestateplugin_load_bill_stuff()
{
    wp_enqueue_script('jquery-ui-core');
}
add_action('wp_loaded', 'realestateplugin_load_bill_stuff'); ?>