<?php 

/**

 * @author Bill Minozzi

 * @copyright 2017

 */

namespace realestate\WP\Settings;

// http://autosellerplugin.com/wp-admin/tools.php?page=md_settings1

// $mypage = new Page('Settings', array('type' => 'submenu2', 'parent_slug' =>'admin.php?page=real_estate_plugin'));

// $mypage = new Page('md_settings', array('type' => 'submenu', 'parent_slug' =>'tools.php'));

  $mypage = new Page('md_settings', array('type' => 'submenu2', 'parent_slug' =>'real_estate_plugin'));

 // $mypage = new Page('md_settings', array('type' => 'menu'));

$msg = 'This is a scction 1 ... ';

$settings = array();

//$settings['Mutidealer Settings']['Mutidealer Settings'] = array('info' => $msg );

$fields = array();

$fields[] = array(

	'type' 	=> 'select',

	'name' 	=> 'RealEstatecurrency',

	'label' => __('Currency', 'realestate'),

	'select_options' => array(

		array('value'=>'Dollar', 'label' => 'Dollar'),

		array('value'=>'Euro', 'label' => 'Euro'),

		array('value'=>'AUD', 'label' => 'Australian Dollar'),

		array('value'=>'Pound', 'label' => 'Pound'),

		array('value'=>'Real', 'label' => 'Brazil Real'),

		array('value'=>'Yen', 'label' => 'Yen'),

		array('value'=>'Universal', 'label' => 'Universal')     

		)			

	);

    $fields[] = array(

	'type' 	=> 'select',

	'name' 	=> 'RealEstate_measure',

	'label' => __('Meters - Feets','realestate'),

	'select_options' => array(

		array('value'=>'M2', 'label' => __('Meters', 'realestate')),

		array('value'=>'Sq Ft', 'label' => __('Feets', 'realestate')),


		)			

	);

/*
    $fields[] = array(

	'type' 	=> 'select',

	'name' 	=> 'RealEstate_liter',

	'label' => __('Liters - Gallons','realestate'),

	'select_options' => array(

		array('value'=>'Liters', 'label' => __('Liters', 'realestate')),

		array('value'=>'Gallons', 'label' => __('Gallons', 'realestate')),

		)			

	);

    

    $fields[] = array(

	'type' 	=> 'select',

	'name' 	=> 'RealEstate_lenght',

	'label' => __('Feet - Meters','realestate'),

	'select_options' => array(

		array('value'=>'Feet', 'label' => __('Feet', 'realestate')),

		array('value'=>'Meters', 'label' => __('Meters', 'realestate') ),

		)			

	);

 */

	$fields[] =	array(

            	'type' 	=> 'select',

				'name' => 'RealEstate_quantity',

				'label' => __('How many properties would you like to display per page?', 'realestate'),

				'select_options' => array (

                		array('value'=>'1', 'label' => '1'),

	                	array('value'=>'2', 'label' => '2'),

                		array('value'=>'3', 'label' => '3'),

	                	array('value'=>'4', 'label' => '4'),

                		array('value'=>'5', 'label' => '5'),

	                	array('value'=>'6', 'label' => '6'),

                 		array('value'=>'7', 'label' => '7'),

	                	array('value'=>'8', 'label' => '8'),

                		array('value'=>'9', 'label' => '9'),

	                	array('value'=>'10', 'label' => '10'),

                		array('value'=>'11', 'label' => '11'),

	                	array('value'=>'12', 'label' => '12'),

	         	)

 	); 

/*

$fields[] = array(

	'type' 	=> 'radio',

	'name' 	=> 'sidebar_search_page_result',

	'label' => __('Use dedicated Search Results Page').'?',

	'radio_options' => array(

		array('value'=>'yes', 'label' => 'Yes'),

		array('value'=>'no', 'label' => 'No'),

		)			

	);

*/

$fields[] = array(

	'type' 	=> 'radio',

	'name' 	=> 'sidebar_search_page_result',

	'label' => __('Remove Sidebar from Search Result Page').'?',

	'radio_options' => array(

		array('value'=>'yes', 'label' => 'Yes'),

		array('value'=>'no', 'label' => 'No'),

		)			

	);

 $fields[] = array(

	'type' 	=> 'radio',

	'name' 	=> 'RealEstate_overwrite_gallery',

	'label' => __('Replace the Wordpress Gallery with Flexslider Gallery','realestate').'?',

	'radio_options' => array(

		array('value'=>'yes', 'label' => 'Yes'),

		array('value'=>'no', 'label' => 'No'),

		)			

	);   

$fields[] = array(

	'type' 	=> 'text',

	'name' 	=> 'RealEstate_recipientEmail',

	'label' => __('Fill out your contact email to receive email from your Contact Form at bottom of the individual Product page.' ,'realestate')

    ); 

   $fields[] = array(

	'type' 	=> 'text',

	'name' 	=> 'RealEstate_googlemapsapi',

	'label' => __('Optional. Fill out your Google API to use with yours maps (google maps)' ,'realestate')

    );   

 /*

 $fields[] = array(

	'type' 	=> 'radio',

	'name' 	=> 'RealEstate_template_gallery',

	'label' => __('In Show Room Page, use Gallery or List View Template','realestate').'?',

	'radio_options' => array(

		array('value'=>'yes', 'label' => 'Gallery'),

		array('value'=>'no', 'label' => 'List View'),

		)			

	);  

 */

// $msg = 'Hi ';

$settings['Real Estate Settings']['Settings']['fields'] = $fields;

new OptionPageBuilderTabbed($mypage, $settings);