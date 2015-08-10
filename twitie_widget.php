<?php
/*
Plugin Name: Tweetie Widget
Plugin URI: 
Description: This is a simple twitter widget that is easily 
Version: 1.0
Author: Costello Coding
Author URI: http://costellocoding.com/
License: GPL2
*/

add_action('wp_enqueue_scripts','tweetie_js');

function tweetie_js() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'tweetie_js', plugins_url( '/js/tweetie.js', __FILE__ ), array('jquery'), '1.0.0');
}

class tweetie_widget extends WP_Widget {

	// constructor
	function tweetie_widget() {
		parent::WP_Widget(false, $name = __('Tweetie Widget', 'wp_widget_plugin') );
	}

	// widget form creation
	function form($instance) {

		// Check values
		if( $instance) {
			$title = esc_attr($instance['title']);
			$tw_id = esc_attr($instance['tw_id']);
			$tw_username = esc_attr($instance['tw_username']);
			$tw_dateformat = esc_attr($instance['tw_dateformat']);
			$tw_count = esc_attr($instance['tw_count']);
			$tw_loading_text = esc_attr($instance['tw_loading_text']);
			$tw_template = esc_textarea($instance['tw_template']);
		} else {
			$title = '';
			$tw_id = '';
			$tw_username = '';
			$tw_dateformat = '';
			$tw_count = '';
			$tw_loading_text = '';
			$tw_template = '';
		}
		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_id'); ?>"><?php _e('Id:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tw_id'); ?>" name="<?php echo $this->get_field_name('tw_id'); ?>" type="text" value="<?php echo $tw_id; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_username'); ?>"><?php _e('Username:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tw_username'); ?>" name="<?php echo $this->get_field_name('tw_username'); ?>" type="text" value="<?php echo $tw_username; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_dateformat'); ?>"><?php _e('Date Format:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tw_dateformat'); ?>" name="<?php echo $this->get_field_name('tw_dateformat'); ?>" type="text" value="<?php echo $tw_dateformat; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_count'); ?>"><?php _e('Number of Tweets:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tw_count'); ?>" name="<?php echo $this->get_field_name('tw_count'); ?>" type="text" value="<?php echo $tw_count; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_loading_text'); ?>"><?php _e('Loading Text:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tw_loading_text'); ?>" name="<?php echo $this->get_field_name('tw_loading_text'); ?>" type="text" value="<?php echo $tw_loading_text; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('tw_template'); ?>"><?php _e('Tweet Template:', 'wp_widget_plugin'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('tw_template'); ?>" name="<?php echo $this->get_field_name('tw_template'); ?>"><?php echo $tw_template; ?></textarea>
		</p>
		<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['tw_id'] = strip_tags($new_instance['tw_id']);
		$instance['tw_username'] = strip_tags($new_instance['tw_username']);
		$instance['tw_dateformat'] = strip_tags($new_instance['tw_dateformat']);
		$instance['tw_count'] = strip_tags($new_instance['tw_count']);
		$instance['tw_loading_text'] = strip_tags($new_instance['tw_loading_text']);
		$instance['tw_template'] = $new_instance['tw_template'];
		return $instance;
	}

	// display widget
	function widget($args, $instance) {


		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		$tw_id = $instance['tw_id'];
		$tw_username = $instance['tw_username'];
		$tw_dateformat = $instance['tw_dateformat'];
		$tw_count = $instance['tw_count'];
		$tw_loading_text = $instance['tw_loading_text'];
		$tw_template = $instance['tw_template'];
		
		echo $before_widget;
		echo "<h2 class='widget-title'>".$title."</h2>";
		echo '<div class="tw_'.$tw_id.'">';
        echo '<div class="tweet"></div>';
    echo '</div>';
    echo '<script type="text/javascript">';
        echo "jQuery('.tw_".$tw_id." .tweet').twittie({\n";
        		echo "username: '".$tw_username."',\n";
            echo "dateFormat: '".$tw_dateformat."',\n";
            echo "template: '".$tw_template."',\n";
            echo "count: ".$tw_count.",\n";
            echo "loadingText: '".$tw_loading_text."',\n";
            echo "apiPath: 'wp-content/plugins/tweetie_widget/api/tweet.php'\n";
        echo '});';
    echo '</script>';
		echo $after_widget;
	}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("tweetie_widget");'));


?>
