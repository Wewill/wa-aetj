<?php
/**
 * Register the taxonomies custom meta fields.
 *
 * @since    1.1.0
 */

// Taxonomies 
function register_custom_term_meta_fields() {
	// Taxonomies 
	add_filter( 'rwmb_meta_boxes', 'artist_fields', 10);
}

function artist_fields( $meta_boxes ) {
    $prefix = 'a_';

    $meta_boxes[] = [
        'title'      => __( 'Artist › General', 'wa-rsfp' ),
        'id'         => 'artist-general',
        'taxonomies' => ['directory-artist'],
        'fields'     => [
            [
                'name'             => __( 'Image', 'wa-rsfp' ),
                'id'               => $prefix . 'general_image',
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
				'label_description' => __( '<span class="label">INFO</span> Choose an image as featured image', 'wa-aetj' ),
            ],
        ],
    ];

    return $meta_boxes;
}