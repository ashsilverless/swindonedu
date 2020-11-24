<?php
/*
// ========= Custom Post Types - Course Archives ============
*/

add_action( 'init', 'custom_post_type_course_archive', 10 );
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
		'menu_icon'           => 'dashicons-text-page',
		'menu_position' 	  => 0,
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);

	register_post_type( 'course_archive', $args );
}

add_action( 'init', 'custom_post_type_video_archive', 20 );
function custom_post_type_video_archive() {

	$labels = array(
		'name'                => _x( 'Video Archives', 'Post Type General Name',  'swindonedu' ),
		'singular_name'       => _x( 'Video Archive',  'Post Type Singular Name', 'swindonedu' ),
		'menu_name'           => __( 'Video Archive',         'swindonedu' ),
		'parent_item_colon'   => __( 'Parent Video Archive',  'swindonedu' ),
		'all_items'           => __( 'All Video Archives',   'swindonedu' ),
		'view_item'           => __( 'View Video Archive',    'swindonedu' ),
		'add_new_item'        => __( 'Add New Video Archive', 'swindonedu' ),
		'add_new'             => __( 'Add Video Archive',     'swindonedu' ),
		'edit_item'           => __( 'Edit Video Archive',    'swindonedu' ),
		'update_item'         => __( 'Update Video Archive',  'swindonedu' ),
		'search_items'        => __( 'Search Video Archives',  'swindonedu' ),
		'not_found'           => __( 'Not Found',          'swindonedu' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'swindonedu' )
	);

	$args = array(
		'label'               => __( 'video_archive', 'swindonedu' ),
		'description'         => __( 'Video Archive', 'swindonedu' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'menu_icon'           => 'dashicons-video-alt2',
		'menu_position' 	  => 0,
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);

	register_post_type( 'video_archive', $args );
}

// ====== Type Taxonomy
add_action( 'init', 'taxonomy_type', 0 );
function taxonomy_type() {

	$labels = array(
		'name'              => _x( 'Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Types'   ),
		'all_items'         => __( 'All Types'     ),
		'parent_item'       => __( 'Parent Type'   ),
		'parent_item_colon' => __( 'Parent Type:'  ),
		'edit_item'         => __( 'Edit Type'     ),
		'update_item'       => __( 'Update Type'   ),
		'add_new_item'      => __( 'Add New Type'  ),
		'new_item_name'     => __( 'New Type' ),
		'menu_name'         => __( 'Types'         )
	);

	register_taxonomy( 'type', array( 'course_archive' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'type', 'hierarchical' => true )
	));
}

// ====== Video Type Taxonomy
add_action( 'init', 'taxonomy_video_type', 0 );
function taxonomy_video_type() {

	$labels = array(
		'name'              => _x( 'Video Type', 'taxonomy general name' ),
		'singular_name'     => _x( 'Video Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Video Types'   ),
		'all_items'         => __( 'All Video Types'     ),
		'parent_item'       => __( 'Parent Video Type'   ),
		'parent_item_colon' => __( 'Parent Video Type:'  ),
		'edit_item'         => __( 'Edit Video Type'     ),
		'update_item'       => __( 'Update Video Type'   ),
		'add_new_item'      => __( 'Add New Video Type'  ),
		'new_item_name'     => __( 'New Video Type' ),
		'menu_name'         => __( 'Video Types'         )
	);

	register_taxonomy( 'video_type', array( 'video_archive' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'video_type', 'hierarchical' => true )
	));
}

/*add_action( 'init', 'taxonomy_course_category', 0 );
// ====== Type Taxonomy
function taxonomy_course_category() {

	$labels = array(
		'name'              => _x( 'Course Category', 'taxonomy general name' ),
		'singular_name'     => _x( 'Course Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Course Categories'   ),
		'all_items'         => __( 'Course Categories'     ),
		'parent_item'       => __( 'Parent Course Category'   ),
		'parent_item_colon' => __( 'Parent Course Category:'  ),
		'edit_item'         => __( 'Edit Course Category'     ),
		'update_item'       => __( 'Update Course Category'   ),
		'add_new_item'      => __( 'Add New Course Category'  ),
		'new_item_name'     => __( 'New Course Category' ),
		'menu_name'         => __( 'Course Category'         )
	);

	register_taxonomy( 'course_category', array( 'course_archive' ), array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'course_category', 'hierarchical' => true )
	));
}*/
