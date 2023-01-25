<?php

add_filter('attachment_fields_to_edit', function ($fields, $post) {
    $property_selected = get_post_meta($post->ID, 'property-post-id', true);
    $select_args = [
        'post_type' => 'property',
        'selected' => $property_selected,
        'name' => 'attachments[' . $post->ID . '][property-post-id]',
        'id' => 'attachments[' . $post->ID . '][property-post-id]',
        'echo' => 0,
        'show_option_none' => __('Select a property')
    ];
    // select fields for property images 
    $fields['property-post-id'] = [
        'label' => __('Property', 'agence'),
        'input' => 'html',
        'html' => wp_dropdown_pages($select_args),
        'value' => $property_selected,
        'helps' => __('This image is linked to this property', 'agence'),
    ];
    return $fields;
}, null, 2);

add_action('attachment_fields_to_save', function ($post, $attachment) {
    // echo '<pre>';
    // print_r([
    //     'post' => $post,
    //     'attachment' => $attachment
    // ]);
    // echo '</pre>';
    // die();
    wp_update_post([
        "ID" => $post['ID'],
        "post_parent" => $attachment['property-post-id'],
    ]);
}, null, 2);
