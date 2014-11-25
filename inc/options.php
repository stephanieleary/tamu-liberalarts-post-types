<?php

// add the pages to the navigation menu
add_action('admin_menu', 'liberal_arts_add_options_page');

function liberal_arts_add_options_page() {
    // Add a new submenu under Settings:
	add_options_page(__('Liberal Arts Post Types'), __('Post Types'), 'manage_options', 'liberal-arts-cpts', 'liberal_arts_options');
}



function liberal_arts_sanitize_options($input) {
	
	$options = array();
	
	foreach ( $input['post_types'] as $post_type => $toggle ) {
		$options['post_types'][$post_type] = absint( $toggle );	
	}
		
	$options['people_display_template'] = force_balance_tags( $input['people_display_template'] );
	
	/*
	// testing
	var_dump($input);
	var_dump($options); exit;
	/**/
	
	return $options;
}

// displays the options page content
function liberal_arts_options() { ?>	
    <div class="wrap">
	<form method="post" id="liberal_arts_form" action="options.php">
		<?php settings_fields('liberal_arts_cpts'); 
		$options = get_option('liberal_arts_cpts');
		
		if ( !isset($options['people_display_template']) || empty($options['people_display_template']) )
			$options['people_display_template'] = '<h3>Contact Info</h3>
			Email: <a href="mailto:[acf field="email"]">[acf field="email"]</a>
			Phone: [acf field="phone"]
			Office: [acf field="building"] [acf field="room"]
			
			<h3>CV</h3>
			<a href="[acf field="vita"]">Download CV</a>
			
			<h3>About</h3>';
		
		// testing
		// var_dump($options); 
		?>

    <h2><?php _e( 'Liberal Arts Post Types'); ?></h2>
    
    <table class="form-table">
	    <tr>
	    <th scope="row"><?php _e("Post types" ); ?></th>
		    <td>
			    <ul id="liberal_arts_types">
			    <?php
			    $post_types = array( 'course', 'degree_requirement', 'people', 'publication', 'dissertation' );
			    
			    foreach ($post_types as $content_type) { ?>
			    		<li>
			    		<label>
			    		<input type="checkbox" name="liberal_arts_cpts[post_types][<?php echo $content_type; ?>]" value="1" <?php checked( '1', $options['post_types'][$content_type] ); ?> />
			    		<?php echo $content_type; ?></label>
			    		</li>
			    	<?php 
			    }
			    ?>
			    </ul>
		    </td>
	    </tr>

		<tr>
			<th scope="row"><?php _e("People template" ); ?></th>
		    <td>
				<p><em><?php _e( sprintf( 'You may use <a href="%s">Custom Field names</a> in the format: [acf field="name"]. <a href="http://www.advancedcustomfields.com/resources/shortcode/">More info</a>', admin_url( 'edit.php?post_type=acf-field-group' ) ) ); ?></em>
				</p>
				<textarea name="liberal_arts_cpts[people_display_template]" class="widefat"><?php echo esc_textarea( $options['people_display_template'] ); ?></textarea>
		    </td>
	    </tr>


    </table>
    
	<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="<?php _e('Update Options' ); ?>" />
	</p>
	</form>
	</div>
<?php 
} // end function liberal_arts_options() 