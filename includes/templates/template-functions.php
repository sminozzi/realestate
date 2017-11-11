<?php 
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
 function realestate_maps()
 {
    $googleapi = get_option('RealEstate_googlemapsapi', 6); 
    if( empty($googleapi))
       return;
    $post_product_id = get_the_ID();   
    $value = get_post_meta($post_product_id, 'product-googlemap', true);
    if(empty($value))
      return;
    echo '<div id="realestate_googleMap"></div>';
    $googlemap = explode(PHP_EOL, $value);
                if (isset($googlemap[0]))
                    $googlemap_latitude = $googlemap[0];
                else
                    $googlemap_latitude = '';
                if (isset($googlemap[1]))
                    $googlemap_longitude = $googlemap[1];
                else
                    $googlemap_longitude = '';
                if (isset($googlemap[2]))
                    $googlemap_zoom = $googlemap[2];
                else
                    $googlemap_zoom = '';
                /*    
                if (isset($googlemap[3]))
                    $googlemap_address = $googlemap[3];
                else
                    $googlemap_address = '';
                 */
   if(count($googlemap) == 4)
   {
?>  
    <script>
      function realestate_initMap() {
        var guluru = {lat: <?php echo $googlemap_latitude;?>, lng: <?php echo $googlemap_longitude;?>};
        var map = new google.maps.Map(document.getElementById('realestate_googleMap'), {
          zoom: <?php echo $googlemap_zoom;?>,
          center: guluru
        });
        var marker = new google.maps.Marker({
          position: guluru,
          map: map
        });
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleapi;?>&callback=realestate_initMap" type="text/javascript">
    </script>
<?php
   }   
   return true;
 }
 function realestate_content_detail (){
    $post_product_id = get_the_ID();
    ?>
    <div class="multi-content">
        <div id="sliderWrapper">
                 <?php
                   $agent = get_the_terms( get_the_id(), 'agents');
                 if(is_array($agent))
                    {
                         $agent = $agent[0]; 
                         if(! empty($agent))
                         { 
                             echo '<div class="featuredTitle">'; 
                             echo __('Agent', 'realestate').': ';  
                             echo esc_attr($agent->name);
                         } 
                         echo '</div><br />';
                    }                
                   if (get_post_meta(get_the_ID(), 'product-address', 'true') != '') { 
                         $address = trim(get_post_meta(get_the_ID(), 'product-address', 'true'));
                         if(! empty($address)) 
                         {
                           echo '<div class="featuredTitle">'; 
                           echo '&nbsp;&nbsp;&nbsp;';
                           echo __('Address', 'realestate').': ';  
                          // echo esc_attr($term1->name);
                           echo $address;
                           echo '</div><br />'; 
                         } 
                   }
                 realestate_maps();
                 $terms3 = get_the_terms( get_the_id(), 'locations');
                 $term3 = $terms3[0]; 
                 if(is_object($term3))
                    {
                         echo '<div class="featuredTitle">'; 
                         echo __('Location', 'realestate').': ';  
                         echo esc_attr($term3->name); 
                         echo '</div><br />';
                    } 
                 ?>
             <div class="featuredTitle"> 
             <?php echo __('Options', 'realestate');?> </div>
  			 <div class="featuredCar">
             <?php 
              if (get_post_meta(get_the_ID(), 'product-beds', 'true') != '') { ?>
             <div class="featuredList">             
             <span class="carBold"> <?php echo __('Beds', 'cardealer');?>: </span><?php echo get_post_meta(get_the_ID(), 'product-beds', 'true');
              ?> 
             </div><!-- End of featured list -->
             <?php }
              if (get_post_meta(get_the_ID(), 'product-baths', 'true') != '') { ?>
             <div class="featuredList">             
             <span class="carBold"> <?php echo __('Baths', 'cardealer');?>: </span><?php echo get_post_meta(get_the_ID(), 'product-baths', 'true');
             ?> 
             </div><!-- End of featured list -->
             <?php }
             if (get_post_meta(get_the_ID(), 'product-area', 'true') != '') { ?>
             <div class="featuredList">             
             <span class="carBold"> 
             <?php echo $RealEstate_measure = get_option('RealEstate_measure', 'M2');?>:           
             </span><?php echo get_post_meta(get_the_ID(), 'product-area', 'true');
             ?> 
             </div><!-- End of featured list -->
             <?php }
        $afieldsId = realestate_get_fields('all');
        $totfields = count($afieldsId);
        $ametadataoptions = array();
        for ($i = 0; $i < $totfields; $i++) {
            $post_id = $afieldsId[$i];
            $ametadata = realestate_get_meta($post_id);        
            if (!empty($ametadata[0]))
                $label = $ametadata[0];
            else
                $label = $ametadata[12];
            $field_id = 'product-'.$ametadata[12];
            $value = get_post_meta($post_product_id, $field_id, true);
             $typefield = $ametadata[1];
             if ($value != '' and $typefield != 'googlemap' ) 
             { 
                 if ($typefield == 'checkbox')
                   if($value == 'enabled')
                     $value = 'Ok';
                   else
                     $value = 'No';
                  ?>
                 <div class="featuredList">             
                 <span class="multiBold"> <?php echo $label;?>: </span><?php echo '<b>'.$value.'</b>';?> 
                 </div><!-- End of featured list --><?php }
             }
             ?>
             </div><!-- End of featured multi -->
             </div> <!-- end of Slider Content --> 
             </div> <!-- end of Slider Wrapper -->  
     <?php }
 function realestate_content_info () { ?>
 <div class="contentInfo">
         <div class="multiPriceSingle">
         	<?php 
            $price = get_post_meta(get_the_ID(), 'product-price', true);
                if (!empty($price))
                     {$price =   number_format_i18n($price,0);}
    		if ( $price <> '') {
    			echo realestate_currency().$price;
    		}else {
    		 echo __('Call for Price', 'realestate');	
    		}
    		?> 
         </div>
         <div class="multiPurposeSingle">
         	<?php 
            $purpose = get_post_meta(get_the_ID(), 'product-purpose', true);
    		// die($year);
            if ( $purpose <> '') 
    			echo __($purpose, 'realestat');
    		?> 
         </div>
         <div class="multiYearSingle">
         	<?php 
            $year = get_post_meta(get_the_ID(), 'product-year', true);
    		// die($year);
            if ( $year <> '') 
    			echo __('Year', 'realestat').': '.$year;
    		?> 
         </div>
         <div class="multiContent">
         	<?php the_content(); ?>
         </div> 
            <?php 
            $year = get_post_meta(get_the_ID(), 'multi-year', 'true'); 
            if($year)
            { ?>
            <div class="multiDetail">
                 <?php echo __('Year', 'realestate').': ';
                   echo $year; 
                ?>
                <!--
                <div class="multiBasicRow"><span class="singleInfo"><?php echo __(get_option('RealEstate_measure', 'Miles'), 'realestate')?>: </span> <?php echo get_post_meta(get_the_ID(), 'multi-miles', 'true'); ?></div>
                <div class="multiBasicRow"><span class="singleInfo"><?php echo __('Cond', 'realestate');?>: </span> <?php echo get_post_meta(get_the_ID(), 'multi-con', 'true'); ?></div>
                <div class="multiBasicRow"><span class="singleInfo"><?php echo __('HP', 'realestate');?>:&nbsp; </span> <?php echo get_post_meta(get_the_ID(), 'multi-hp', 'true'); ?></div>
                -->
            </div>
            <?php } ?> 
 </div>	 
 <?php }
function realestate_realestate_detail() {
  echo '<div class="multi-content">';
	while ( have_posts() ) : the_post(); 
       realestate_title_detail();
       realestate_content_info (); 
      ?> 
     <div class="multicontentWrap">
	 <?php realestate_content_detail (); ?>
     </div><?php
     return;
	 endwhile; // end of the loop.
     echo '</div>';
}
function realestate_title_detail(){
global $realestate_the_title;
   $realestate_the_title = get_the_title(); ?>
    <div class="multi-detail-title">  <?php the_title(); ?> </div>
<?php }
function RealEstate_theme_thumb($url, $width, $height=0, $align='') {
        if (get_the_post_thumbnail()=='') {
    	  	$url = REALESTATEIMAGES.'image-no-available.jpg';
		}
       return $url;
}