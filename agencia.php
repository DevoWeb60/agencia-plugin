<?php

/**
 * Plugin Name: Agencia 
 * Description: Plugin pour le thème Agencia
 * Version: 0.1
 * Author: DevoWeb
 * Author URI: https://www.devoweb.fr
 * Text Domain: agence
 * Domain Path: /languages
 */


defined('ABSPATH') or die('No script kiddies please!');

add_action('plugins_loaded', function () {
    load_plugin_textdomain('agence', false, basename(dirname(__FILE__)) . '/languages');
});

require_once('inc/media.php');
require_once('inc/functions.php');
require_once('inc/query.php');
require_once('inc/rewrite.php');

add_action('init', function () {
    register_post_type('property', [
        'label' => __('Properties', 'agence'),
        'menu_icon' => 'dashicons-building',
        'labels' => [
            'name' => __('Properties', 'agence'),
            'singular_name' => __('Property', 'agence'),
            'add_new_item' => __('Add property', 'agence'),
            'edit_item' => __('Edit property', 'agence'),
            'new_item' => __('New property', 'agence'),
            'view_item' => __('View property', 'agence'),
            'view_items' => __('View properties', 'agence'),
            'search_items' => __('Search properties', 'agence'),
            'not_found' => __('Properties not found', 'agence'),
            'not_found_in_trash' => __('No property in trash', 'agence'),
            'all_items' => __('All properties', 'agence'),
            'archives' => __('Archived properties', 'agence'),
            'filter_items_list' => __('Properties filter list', 'agence'),
            'items_list_navigation' => __('Properties navigation list', 'agence'),
            'items_list' => __('Properties list', 'agence'),
            'item_published' => __('Property published', 'agence'),
            'item_published_privately' => __('Private property published', 'agence'),
            'item_reverted_to_draft' => __('Property reverted to draft', 'agence'),
            'item_scheduled' => __('Property scheduled', 'agence'),
            'item_updated' => __('Property updated', 'agence'),
        ],
        'description' => __('Estate properties', 'agence'),
        'public' => true,
        'menu_position' => 5,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'hierarchical' => true,
        'rewrite' => [
            'slug' => _x('property', 'URL', 'agence'),
        ],
        'exclude_from_search' => false,
        'taxonomies' => ['property_type', 'property_city'],
        'show_in_rest' => true,
        "has_archive" => true,
        'exclude_from_search' => true,
    ]);

    register_taxonomy('property_type', 'property', [
        'label' => __('Types', 'agence'),
        'labels' => [
            'name' => __('Types', 'agence'),
            'singular_name' => __('Property type', 'agence'),
            'search_items' => __('Search property types', 'agence'),
            'popular_items' => __('Popular property types', 'agence'),
            'all_items' => __('All property types', 'agence'),
            'edit_item' => __('Edit property type', 'agence'),
            'update_item' => __('Update property type', 'agence'),
            'add_new_item' => __('Add new property type', 'agence'),
            'new_item_name' => __('New property type', 'agence'),
            'separate_items_with_commas' => __('Separate property types with commas', 'agence'),
            'add_or_remove_items' => __('Add or remove property types', 'agence'),
            'choose_from_most_used' => __('Choose from the most used property types', 'agence'),
            'not_found' => __('No property type found', 'agence'),
            'no_terms' => __('No property type', 'agence'),
            'items_list_navigation' => __('Property types navigation list', 'agence'),
            'items_list' => __('Property types list', 'agence'),
        ],
        'description' => __('Property types', 'agence'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);
    register_taxonomy('property_city', 'property', [
        'label' => __('Cities', 'agence'),
        'labels' => [
            'name' => __('Cities', 'agence'),
            'singular_name' => __('city', 'agence'),
            'search_items' => __('Search cities', 'agence'),
            'popular_items' => __('Popular cities', 'agence'),
            'all_items' => __('All cities', 'agence'),
            'edit_item' => __('Edit city', 'agence'),
            'update_item' => __('Update city', 'agence'),
            'add_new_item' => __('Add new city', 'agence'),
            'new_item_name' => __('New city', 'agence'),
            'separate_items_with_commas' => __('Separate cities with commas', 'agence'),
            'add_or_remove_items' => __('Add or remove cities', 'agence'),
            'choose_from_most_used' => __('Choose from the most used cities', 'agence'),
            'not_found' => __('No city found', 'agence'),
            'no_terms' => __('No city', 'agence'),
            'items_list_navigation' => __('Cities navigation list', 'agence'),
            'items_list' => __('Cities list', 'agence'),
        ],
        'description' => __('Cities for properties', 'agence'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);
    register_taxonomy('property_option', 'property', [
        'label' => __('Options', 'agence'),
        'labels' => [
            'name' => __('Options', 'agence'),
            'singular_name' => __('option', 'agence'),
            'search_items' => __('Search Options', 'agence'),
            'popular_items' => __('Popular Options', 'agence'),
            'all_items' => __('All Options', 'agence'),
            'edit_item' => __('Edit option', 'agence'),
            'update_item' => __('Update option', 'agence'),
            'add_new_item' => __('Add new option', 'agence'),
            'new_item_name' => __('New option', 'agence'),
            'separate_items_with_commas' => __('Separate Options with commas', 'agence'),
            'add_or_remove_items' => __('Add or remove Options', 'agence'),
            'choose_from_most_used' => __('Choose from the most used Options', 'agence'),
            'not_found' => __('No option found', 'agence'),
            'no_terms' => __('No option', 'agence'),
            'items_list_navigation' => __('Options navigation list', 'agence'),
            'items_list' => __('Options list', 'agence'),
        ],
        'description' => __('Options for properties', 'agence'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ]);
});

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
