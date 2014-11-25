<?php
/*
Plugin Name: Liberal Arts Custom Post Types and Taxonomies
Version: 1.1
Author: Stephanie Leary
Author URI: http://stephanieleary.com/
Description: Post types for people, publications, dissertations, courses, and degree requirements, along with all their associated taxonomies.
License: GPL2
*/

// register options
add_action('admin_init', 'liberal_arts_cpts_register_options' );
function liberal_arts_cpts_register_options(){
	register_setting( 'liberal_arts_cpts', 'liberal_arts_cpts', 'liberal_arts_sanitize_options' );
}

// when uninstalled, remove option
register_uninstall_hook( __FILE__, 'liberal_arts_cpts_delete_options' );
function liberal_arts_cpts_delete_options() {
	delete_option('liberal_arts_cpts');
}
// testing only
//register_deactivation_hook( __FILE__, 'liberal_arts_cpts_delete_options' );



// Require Advanced Custom Fields
require_once dirname( __FILE__ ) . '/inc/required-plugins.php';

// Content filters and labels
require_once dirname( __FILE__ ) . '/inc/filters.php';

// options page file
require_once dirname( __FILE__ ) . '/inc/options.php';

// TGM_Plugin_Activation class.
require_once dirname( __FILE__ ) . '/classes/class-tgm-plugin-activation.php';

/* Content Types */

add_action('init', 'create_liberalarts_post_types');
register_activation_hook( __FILE__, 'activate_liberalarts_types' );

function activate_liberalarts_types() {
	create_liberalarts_post_types();
	create_liberalarts_taxes();
	activate_liberalarts_terms();
	flush_rewrite_rules();
}

function create_liberalarts_post_types() {
	
	$options = get_option('liberal_arts_cpts');
	
	if ( isset( $options['post_types']['course'] ) && !empty( $options['post_types']['course'] ) )
   	 register_post_type( 'course', array(
	    'labels' => 	array(
		    'name' => _x( 'Courses', 'course' ),
		    'singular_name' => _x( 'Course', 'course' ),
		    'add_new' => _x( 'Add New', 'course' ),
		    'all_items' => _x( 'Courses', 'course' ),
		    'add_new_item' => _x( 'Add New Course', 'course' ),
		    'edit_item' => _x( 'Edit Course', 'course' ),
		    'new_item' => _x( 'New Course', 'course' ),
		    'view_item' => _x( 'View Course', 'course' ),
		    'search_items' => _x( 'Search Courses', 'course' ),
		    'not_found' => _x( 'No courses found', 'course' ),
		    'not_found_in_trash' => _x( 'No courses found in Trash', 'course' ),
		    'parent_item_colon' => _x( 'Parent Course:', 'course' ),
		    'menu_name' => _x( 'Courses', 'course' ),
		    ),
	    'hierarchical' => false,
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true
	    ) );
	
	if ( isset( $options['post_types']['degree_requirement'] ) && !empty( $options['post_types']['degree_requirement'] ) )
    	register_post_type( 'degree_requirement', array(
	    'labels' => 	array(
		    'name' => _x( 'Degree Requirements', 'degree_requirement' ),
		    'singular_name' => _x( 'Degree Requirement', 'degree_requirement' ),
		    'add_new' => _x( 'Add New', 'degree_requirement' ),
		    'all_items' => _x( 'Degree Requirements', 'degree_requirement' ),
		    'add_new_item' => _x( 'Add New Degree Requirement', 'degree_requirement' ),
		    'edit_item' => _x( 'Edit Degree Requirement', 'degree_requirement' ),
		    'new_item' => _x( 'New Degree Requirement', 'degree_requirement' ),
		    'view_item' => _x( 'View Degree Requirement', 'degree_requirement' ),
		    'search_items' => _x( 'Search Degree Requirements', 'degree_requirement' ),
		    'not_found' => _x( 'No degree requirements found', 'degree_requirement' ),
		    'not_found_in_trash' => _x( 'No degree requirements found in Trash', 'degree_requirement' ),
		    'parent_item_colon' => _x( 'Parent Degree Requirement:', 'degree_requirement' ),
		    'menu_name' => _x( 'Degree Requirements', 'degree_requirement' ),
		    ),
	    'hierarchical' => false,
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true
	    ) );

	if ( isset( $options['post_types']['people'] ) && !empty( $options['post_types']['people'] ) )
	    register_post_type( 'people', array(
	    'labels' => 	array(
		    'name' => _x( 'People', 'people' ),
		    'singular_name' => _x( 'Person', 'people' ),
		    'add_new' => _x( 'Add New', 'people' ),
		    'all_items' => _x( 'People', 'people' ),
		    'add_new_item' => _x( 'Add New Person', 'people' ),
		    'edit_item' => _x( 'Edit Person', 'people' ),
		    'new_item' => _x( 'New Person', 'people' ),
		    'view_item' => _x( 'View Person', 'people' ),
		    'search_items' => _x( 'Search People', 'people' ),
		    'not_found' => _x( 'No people found', 'people' ),
		    'not_found_in_trash' => _x( 'No people found in Trash', 'people' ),
		    'parent_item_colon' => _x( 'Parent Person:', 'people' ),
		    'menu_name' => _x( 'People', 'people' ),
		    ),
	    'hierarchical' => false,
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true
	    ) );
	
	if ( isset( $options['post_types']['publication'] ) && !empty( $options['post_types']['publication'] ) )
		register_post_type( 'publication', array(
		'labels' => 	array(
			'name' => _x( 'Publications', 'publication' ),
			'singular_name' => _x( 'Publication', 'publication' ),
			'add_new' => _x( 'Add New', 'publication' ),
			'all_items' => _x( 'Publications', 'publication' ),
			'add_new_item' => _x( 'Add New Publication', 'publication' ),
			'edit_item' => _x( 'Edit Publication', 'publication' ),
			'new_item' => _x( 'New Publication', 'publication' ),
			'view_item' => _x( 'View Publication', 'publication' ),
			'search_items' => _x( 'Search Publications', 'publication' ),
			'not_found' => _x( 'No publications found', 'publication' ),
			'not_found_in_trash' => _x( 'No publications found in Trash', 'publication' ),
			'parent_item_colon' => _x( 'Parent Publication:', 'publication' ),
			'menu_name' => _x( 'Publications', 'publication' ),
			),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true
		) );
	
	if ( isset( $options['post_types']['dissertation'] ) && !empty( $options['post_types']['dissertation'] ) )
	    register_post_type( 
		'dissertation',
		 array( 'labels' => array(
		    'name' => _x( 'Theses and Dissertations', 'dissertation' ),
		    'singular_name' => _x( 'Thesis or Dissertation', 'dissertation' ),
		    'add_new' => _x( 'Add New', 'dissertation' ),
		    'all_items' => _x( 'Theses and Dissertations', 'dissertation' ),
		    'add_new_item' => _x( 'Add New Thesis or Dissertation', 'dissertation' ),
		    'edit_item' => _x( 'Edit Thesis or Dissertation', 'dissertation' ),
		    'new_item' => _x( 'New Thesis or Dissertation', 'dissertation' ),
		    'view_item' => _x( 'View Thesis or Dissertation', 'dissertation' ),
		    'search_items' => _x( 'Search Theses and Dissertations', 'dissertation' ),
		    'not_found' => _x( 'No theses or dissertations found', 'dissertation' ),
		    'not_found_in_trash' => _x( 'No theses or dissertations found in Trash', 'dissertation' ),
		    'parent_item_colon' => _x( 'Parent Thesis or Dissertation:', 'dissertation' ),
		    'menu_name' => _x( 'Theses and Dissertations', 'dissertation' ),
		    ),
	    'hierarchical' => false,
	    'public' => true,
	    'show_ui' => true,
	    'show_in_menu' => true
	    ) );
}

/* Taxonomies */

function create_liberalarts_taxes() {
	
	$options = get_option('liberal_arts_cpts');
	
	if ( isset( $options['post_types']['people'] ) && !empty( $options['post_types']['people'] ) ) :
		
		register_taxonomy(
			'classification', //Taxonomy name
			array('people'),  //Content object type(s)
		
			array(
				'labels' => array(
				    'name'                => _x( 'Staff Classifications', 'taxonomy general name' ),
				    'singular_name'       => _x( 'Classification', 'taxonomy singular name' ),
				    'search_items'        => __( 'Search Classifications' ),
				    'all_items'           => __( 'All Classifications' ),
				    'parent_item'         => __( 'Parent Classification' ),
				    'parent_item_colon'   => __( 'Parent Classification:' ),
				    'edit_item'           => __( 'Edit Classification' ), 
				    'update_item'         => __( 'Update Classification' ),
				    'add_new_item'        => __( 'Add New Classification' ),
				    'new_item_name'       => __( 'New Classification Name' ),
				    'menu_name'           => __( 'Classifications' )
				  ),
			'hierarchical' => false,
			'show_admin_column' => true,
			)
		);
	
	register_taxonomy(
		'area',
		array('people'),  //Content object type(s)
		
		array(
			'labels' => array(
			    'name'                => _x( 'Areas', 'taxonomy general name' ),
			    'singular_name'       => _x( 'Area', 'taxonomy singular name' ),
			    'search_items'        => __( 'Search Areas' ),
			    'all_items'           => __( 'All Areas' ),
			    'parent_item'         => __( 'Parent Area' ),
			    'parent_item_colon'   => __( 'Parent Area:' ),
			    'edit_item'           => __( 'Edit Area' ), 
			    'update_item'         => __( 'Update Area' ),
			    'add_new_item'        => __( 'Add New Area' ),
			    'new_item_name'       => __( 'New Area Name' ),
			    'menu_name'           => __( 'Areas' )
			  ),
		'hierarchical' => true,
		'show_admin_column' => true,
		)
	);
	
	register_taxonomy(
		'research', //Taxonomy name
		array('people'),  //Content object type(s)
		
		array(
			'labels' => array(
			    'name'                => _x( 'Research Interests', 'taxonomy general name' ),
			    'singular_name'       => _x( 'Research Interest', 'taxonomy singular name' ),
			    'search_items'        => __( 'Search Research Interests' ),
			    'all_items'           => __( 'All Research Interests' ),
			    'parent_item'         => __( 'Parent Research Interest' ),
			    'parent_item_colon'   => __( 'Parent Research Interest:' ),
			    'edit_item'           => __( 'Edit Research Interest' ), 
			    'update_item'         => __( 'Update Research Interest' ),
			    'add_new_item'        => __( 'Add New Research Interest' ),
			    'new_item_name'       => __( 'New Research Interest' ),
			    'menu_name'           => __( 'Research Interests' )
			  ),
		'hierarchical' => true,
		'show_admin_column' => true,
		)
	);
	
	register_taxonomy(
		'departments', //Taxonomy name
		array('course','people'),  //Content object type(s)
		array(
			'labels' => array(
			    'name'                => _x( 'Departments', 'taxonomy general name' ),
			    'singular_name'       => _x( 'Department', 'taxonomy singular name' ),
			    'search_items'        => __( 'Search Departments' ),
			    'all_items'           => __( 'All Departments' ),
			    'parent_item'         => __( 'Parent Department' ),
			    'parent_item_colon'   => __( 'Parent Department:' ),
			    'edit_item'           => __( 'Edit Department' ), 
			    'update_item'         => __( 'Update Department' ),
			    'add_new_item'        => __( 'Add New Department' ),
			    'new_item_name'       => __( 'New Department Name' ),
			    'menu_name'           => __( 'Departments' ),
				'separate_items_with_commas' => __( 'Separate Departments with commas' ),
				'add_or_remove_items' => __( 'Add or remove Departments' ),
				'choose_from_most_used' => __( 'Choose from the most used Departments' ),
			  ),
		'hierarchical' => true,
		'show_admin_column' => true,
		)
	);
	
	endif;
}

function activate_liberalarts_terms() {
	if ( !taxonomy_exists( 'classification' ) )
		return;
		
	$terms = get_terms( 'classification', array( 'hide_empty' => false, 'fields' => 'ids' ) );
	if ( !empty( $terms ) ) {
		wp_insert_term( __( 'Faculty', 'classification' ) );
		wp_insert_term( __( 'Staff', 'classification' ) );
		wp_insert_term( __( 'Guest Lecturer', 'classification' ) );
		wp_insert_term( __( 'Graduate Assistant', 'classification' ) );
	}
}