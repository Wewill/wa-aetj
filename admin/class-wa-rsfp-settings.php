<?php
/*
Define admin settings
*/

add_filter( 'mb_settings_pages', 'wa_aetj_settings', 50);
function wa_aetj_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title'      => __( 'Custom settings', 'wa_aetj' ),
        'id'              => 'custom-settings',
        'position'        => 50,
        'parent'          => 'options-general.php',
        'class'           => 'wa-aetj',
        // 'tabs'            => [
        //     'edition'  => 'Edition',
        //     'archives' => 'Archives',
        //     'template' => 'Template',
        // ],
        // 'tab_style'       => 'left',
        // 'help_tabs'       => [
        //     [
        //         'title'   => 'Help me !',
        //         'content' => 'Lorem ipsum...',
        //     ],
        // ],
        'customizer'      => false,
        'customizer_only' => false,
        'network'         => false,
        'icon_url'        => 'dashicons-filter',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'wa_aetj_settings_fields', 50);
function wa_aetj_settings_fields( $meta_boxes ) {
    $prefix = 'wa_aetj_';

    $meta_boxes[] = [
        'title'          => __( 'Boat settings', 'wa_aetj' ),
        'id'             => 'boat-settings',
        'settings_pages' => ['custom-settings'],
        'tab'            => 'edition',
        'fields'         => [
            [
                'name'              => __( 'Display boat front notice', 'wa_aetj' ),
                'id'                => $prefix . 'display_boat_notice',
                'type'              => 'switch',
                'label_description' => __( 'Check if you want to display boat front notice on preheader', 'wa_aetj' ),
                'std'               => true,
                'required'          => false,
                'clone'             => false,
                'clone_empty_start' => false,
                'hide_from_rest'    => false,
            ],
        ],
    ];

    return $meta_boxes;
}

function wa_aetj_get_display_boat_notice_from_setting_page() {
    $prefix = 'wa_aetj_';
    return rwmb_meta( $prefix . 'display_boat_notice', [ 'object_type' => 'setting' ], 'custom-settings' );
}