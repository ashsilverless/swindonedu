<?php
/*
// ========= Custom Post Types - Course Archives ============
*/

add_action( 'init', 'custom_post_type_course_archive', 0 );

function custom_post_type_course_archive() {

	$labels = array(
		'name'                => _x( 'Course Archives', 'Post Type General Name',  'swindonedu' ),
		'singular_name'       => _x( 'Course Archive',  'Post Type Singular Name', 'swindonedu' ),
		'menu_name'           => __( 'Course Archive',         'swindonedu' ),
		'parent_item_colon'   => __( 'Parent Course Archive',  'swindonedu' ),
		'all_items'           => __( 'All Course Archives',   'swindonedu' ),
		'view_item'           => __( 'View Course Archive',    'swindonedu' ),
		'add_new_item'        => __( 'Add New Course Archive', 'swindonedu' ),
		'add_new'             => __( 'Add Course Archive',     'swindonedu' ),
		'edit_item'           => __( 'Edit Course Archive',    'swindonedu' ),
		'update_item'         => __( 'Update Course Archive',  'swindonedu' ),
		'search_items'        => __( 'Search Course Archives',  'swindonedu' ),
		'not_found'           => __( 'Not Found',          'swindonedu' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'swindonedu' )
	);

	$args = array(
		'label'               => __( 'course_archive', 'swindonedu' ),
		'description'         => __( 'Course Archive', 'swindonedu' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'menu_icon'           => 'dashicons-index-card',
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);

	register_post_type( 'course_archive', $args );
}
