<?php 
/**
 * @author Bill Minozzi
 * @copyright 2017
 */
function realestate_RecentWidget() {
	register_widget( 'realestate_RecentWidget' );
}
add_action( 'widgets_init', 'realestate_RecentWidget' );
class realestate_RecentWidget extends WP_Widget {
       public function __construct() {
        parent::__construct(
        'RecentWidget',         
        'Recent properties',                
        array( 'description' => __('A list of Recent properties', 'realestate'), ) 
        );
    }   
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'amount' => '','Fwidth' => '','Fheight' => '') );
        if(isset($instance['Ramount']))
          {$Ramount = $instance['Ramount'];}
        else
          {$Ramount = 3;}
		echo '<p>
			<label for="'.$this->get_field_id('Ramount').'">
				Number of properties to show: <input maxlength="1" size="1" id="'. $this->get_field_id('Ramount') .'" name="'. $this->get_field_name('Ramount') .'" type="text" value="'. esc_attr($Ramount) .'" />
			</label>
		</p>';
	}
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
        if(is_numeric($new_instance['Ramount']))
		    {$instance['Ramount'] = $new_instance['Ramount'];}
      	return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$Ramount = empty($instance['Ramount']) ? ' ' : apply_filters('widget_title', $instance['Ramount']); 
		if($Ramount == '') {$Ramount = 3; }
        ?>
	    <div class="sideTitle"> <?php echo __('New Arrivals', 'realestate');?> </div><?php 
		$args = array(
			'post_type'      => 'products',
			'order'    => 'DESC',
			'showposts' => $Ramount,
		);
        $_query3 = new WP_Query( $args );
    $output = '<div class="RealEstate-listing-wrap"> <div class="multiGallery">';
	while ($_query3->have_posts()) : $_query3->the_post();
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'medium', true);	
        $price = get_post_meta(get_the_ID(), 'product-price', true);
            if (!empty($price))
                 {$price =   number_format_i18n($price,0);}
		$image = str_replace("-".$image_url[1]."x".$image_url[2], "", $image_url[0]);
		$featured = trim(get_post_meta(get_the_ID(), 'product-featured', true));
        $thumb = RealEstate_theme_thumb($image, 800, 600, 'br'); // Crops from bottom right
        $year = get_post_meta(get_the_ID(), 'product-year', true);
            $output .= '<div>';
            $output .=  '<a href="' . get_permalink() . '">';
            $output .= '<div class="RealEstate_gallery_2016_widget">';
            $output .=  '<img class="RealEstate_caption_img_widget" src="' . $thumb .'" alt="'. get_the_title() . '" />';
            $output .= '<div class="RealEstate_caption_text_widget">';
            $output .= ($price <> '' ? realestate_currency() . $price : __('Call for Price', 'realestate'));
            $output .= '<br />';
            $output .= ($year <> '' ? __('Year', 'realestate') .': '. $year.'<br />' : '');
            $output .= '</div>';
            $output .= '<div class="multiTitle-widget">' . get_the_title() . '</div>';
            $output .= '</div>';
            $output .= '</a>';
            $output .= '</div>';     
            $output .= '<br />';        
		endwhile; 
        $output .= '</div></div>'; 
        echo $output;
	}
}
function realestate_FeaturedWidget() {
	register_widget( 'realestate_FeaturedWidget' );
}
add_action( 'widgets_init', 'realestate_FeaturedWidget' );
class realestate_featuredWidget extends WP_Widget {
    public function __construct() {
        parent::__construct(
        'FeaturedWidget',         
        'Featured properties',                
        array( 'description' => __('A list of Featured products', 'realestate'), ) 
        );
    } 
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'amount' => '') );
		$amount = $instance['amount'];
		echo '<p>
			<label for="'.$this->get_field_id('amount').'">
				Number of properties to show: <input maxlength="1" size="1" id="'. $this->get_field_id('amount') .'" name="'. $this->get_field_name('amount') .'" type="text" value="'. esc_attr($amount) .'" maxlength="3" size="3" />
			</label>
		</p>';
	}
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
        if(is_numeric($new_instance['amount']))
		    {$instance['amount'] = $new_instance['amount'];}       
		return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$amount = empty($instance['amount']) ? ' ' : apply_filters('widget_title', $instance['amount']); 
		if($amount == '') {$amount = 3; }
    ?>
        <div class="sideTitle"> 
        <?php echo __('Featured properties', 'realestate');?> 
        </div><?php 
		$args = array(
			'post_type'      => 'products',
			'order'    => 'DESC',
			'showposts' => $amount,
			'meta_query' => array(
								array(
										'key' => 'product-featured',
										'value' => 'enabled',
									  )
								   )
		);
        $_query2 = new WP_Query( $args );
		$output = '<div class="RealEstate-listing-wrap"> <div class="multiGallery">';
		while ($_query2->have_posts()) : $_query2->the_post();
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'medium', true);	
        $price = trim(get_post_meta(get_the_ID(), 'product-price', true));
        if(! empty($price))
           $price = number_format_i18n($price);
        $image = str_replace("-".$image_url[1]."x".$image_url[2], "", $image_url[0]);
        $featured = get_post_meta(get_the_ID(), 'product-featured', true);
        $thumb = RealEstate_theme_thumb($image, 800, 600, 'br'); // Crops from bottom right
        $year = get_post_meta(get_the_ID(), 'product-year', true);
            $output .= '<div>';
            $output .=  '<a href="' . get_permalink() . '">';
            $output .= '<div class="RealEstate_gallery_2016_widget">';
            $output .=  '<img class="RealEstate_caption_img_widget" src="' . $thumb .'" alt="'. get_the_title() . '" />';
            $output .= '<div class="RealEstate_caption_text_widget">';
            $output .= ($price <> '' ? realestate_currency() . $price : __('Call for Price', 'realestate'));
            $output .= '<br />';
            $output .= ($year <> '' ? __('Year', 'realestate') .': '. $year : '');
            $output .= '</div>';
            $output .= '<div class="multiTitle-widget">' . get_the_title() . '</div>';
            $output .= '</div>';
            $output .= '</a>';
            $output .= '</div>';     
            $output .= '<br />';
        endwhile; 
        $output .= '</div></div>'; 
        echo $output;
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("realestate_SearchWidget");') );
class realestate_SearchWidget extends WP_Widget {
public function __construct() {
        parent::__construct(
        'SearchWidget',         
        'Search properties',                
        array( 'description' => __('Search properties', 'realestate'), ) 
        );
}     
	function SearchWidget()	{
		$widget_ops = array('classname' => 'SearchWidget', 'description' => 'Search Cars' );
		$this->WP_Widget('SearchWidget', 'Search Widget', $widget_ops);
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'RealEstate_search_name' => '') );
		$RealEstate_search_name = $instance['RealEstate_search_name'];
		echo '<p>
			<label for="'.$this->get_field_id('RealEstate_search_name').'">';
				echo __('Title', 'realestate');
                echo ': <input class="widefat" id="'. $this->get_field_id('RealEstate_search_name') .'" name="'. $this->get_field_name('RealEstate_search_name') .'" type="text" value="'. esc_attr($RealEstate_search_name) .'" />
			</label>
		</p>';
	}
	function update($new_instance, $old_instance) { 
		$instance = $old_instance;
		$instance['RealEstate_search_name'] = $new_instance['RealEstate_search_name'];
		return $instance;
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$RealEstate_search_name = empty($instance['RealEstate_search_name']) ? ' ' : apply_filters('widget_title', $instance['RealEstate_search_name']); 
		if(trim($RealEstate_search_name) == '') {$RealEstate_search_name = __('Search', 'realestate'); }        
        echo '<div class="sideTitle">';
        echo $RealEstate_search_name;
        echo '</div>';        
		echo RealEstate_search(0);
	}   
}