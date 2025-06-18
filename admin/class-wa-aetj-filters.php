<?php
/*
	Adds filters
	https://frankiejarrett.com/2011/09/create-a-dropdown-of-custom-taxonomies-in-wordpress-the-easy-way/
*/

//7
//http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/

// Ajoute des filtres sur les pages concernés 


/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
 
add_action('restrict_manage_posts', 'aetj_filter_post_type_by_taxonomy');
function aetj_filter_post_type_by_taxonomy() {
	global $typenow;
  	global $wp_query;

    // directory-artist
	$taxonomy  = 'directory-artist';
	if ($typenow == 'directory') {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
        if($info_taxonomy) :
        wp_dropdown_categories(array(
			'show_option_all' => sprintf( __('All %s','wa-aetj'), $info_taxonomy->label),
			// 'show_option_none'=> __("—",'wa-aetj'),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
			'hide_if_empty'   => true,
			'hierarchical' 		=> 1,
			'value_field' 		=> 'slug', // Permet de recuperer la query pour selectionner
		));
        endif;
    };

}

/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
add_filter( 'posts_join', 'directory_search_join' );
function directory_search_join ( $join ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'directory' === $_GET['post_type'] && ! empty( $_GET['s'] ) ) {
        $join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
add_filter( 'posts_where', 'directory_search_where' );
function directory_search_where( $where ) {
    global $pagenow, $wpdb;

    // I want the filter only when performing a search on edit page of Custom Post Type named "directory".
    if ( is_admin() && is_search() && 'edit.php' === $pagenow && 'directory' === $_GET['post_type'] && !empty( $_GET['c_state'] ) ) {

		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)",
			$where
		);

		if (isset($_GET['c_state']) && !empty($_GET['c_state'])) {
			$c_state = esc_sql($_GET['c_state']);
			$where .= " AND EXISTS (SELECT 1 FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID AND {$wpdb->postmeta}.meta_key = 'c_state' AND {$wpdb->postmeta}.meta_value = '{$c_state}')";
		}

    }
    return $where;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );
