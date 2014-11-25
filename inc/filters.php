<?php

// Add people template to archive page loop
function liberal_arts_people_loop_display($content) {
	$options = get_option('liberal_arts_cpts');
	$content = wpautop( $options['people_display_template'] ) . $content;
	
	return $content;
}

add_filter('the_content', 'liberal_arts_people_loop_display');

// Change placeholder text for people post titles
function liberal_arts_title_placeholders( $placeholder ){
    $screen = get_current_screen();
	switch ( $screen->post_type ) {
		case 'people':
			$placeholder = 'Enter full name';
			break;
		case 'course': 
			$placeholder = 'Enter course title';
			break;
		default: break;
	}

    return $placeholder;
}

add_filter( 'enter_title_here', 'liberal_arts_title_placeholders' );

// change "posts" to "news" in admin
function liberalarts_post_labels()
{
    global $wp_post_types;
    $p = 'post';

    if ( empty( $wp_post_types[$p] ) or ! is_object( $wp_post_types[$p] ) or empty( $wp_post_types[$p]->labels ) )
        return;

    $wp_post_types[$p]->labels->name               = 'News Articles';
    $wp_post_types[$p]->labels->singular_name      = 'News Article';
    $wp_post_types[$p]->labels->add_new            = 'Add news';
    $wp_post_types[$p]->labels->add_new_item       = 'Add new article';
    $wp_post_types[$p]->labels->all_items          = 'All news';
    $wp_post_types[$p]->labels->edit_item          = 'Edit news article';
    $wp_post_types[$p]->labels->name_admin_bar     = 'News';
    $wp_post_types[$p]->labels->menu_name          = 'News';
    $wp_post_types[$p]->labels->new_item           = 'New article';
    $wp_post_types[$p]->labels->not_found          = 'No articles found';
    $wp_post_types[$p]->labels->not_found_in_trash = 'No articles found in trash';
    $wp_post_types[$p]->labels->search_items       = 'Search news';
    $wp_post_types[$p]->labels->view_item          = 'View news article';
}

add_action( 'wp_loaded', 'liberalarts_post_labels', 20 );