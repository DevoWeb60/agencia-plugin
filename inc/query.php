<?php

defined('ABSPATH') or die('No script kiddies please!');

$propertyCategories = [];


add_filter('query_vars', function (array $params): array {
    $params[] = 'property_category';
    $params[] = 'city';
    $params[] = "price";
    $params[] = "type";
    $params[] = "rooms";
    return $params;
});

add_action('pre_get_posts', function (WP_Query $query) use (&$propertyCategories): void {
    if (is_admin() || !$query->is_main_query() || !is_post_type_archive('property')) {
        return;
    }

    $propertyCategories = [
        _x('buy', 'URL', 'agence') => 'buy',
        _x('rent', 'URL', 'agence') => 'rent',
    ];

    $values = array_keys($propertyCategories);
    if (in_array(get_query_var('property_category'), $values)) {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => 'property_category',
            'value' => $propertyCategories[get_query_var('property_category')],
        ];
        $query->set('meta_query', $meta_query);
    }

    $city = get_query_var('city');
    if ($city) {
        $tax_query = $query->get('tax_query', []);
        $tax_query[] = [
            'taxonomy' => 'property_city',
            'terms' => $city,
            'field' => 'slug',
        ];
        $query->set('tax_query', $tax_query);
    }

    $kind = get_query_var('type');
    if ($kind) {
        $tax_query = $query->get('tax_query', []);
        $tax_query[] = [
            'taxonomy' => 'property_type',
            'terms' => $kind,
            'field' => 'slug',
        ];
        $query->set('tax_query', $tax_query);
    }

    $rooms = (int)get_query_var('rooms');
    if ($rooms) {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => 'rooms',
            'value' => $rooms,
            'compare' => '>=',
            'type' => 'NUMERIC'
        ];
        $query->set('meta_query', $meta_query);
    }

    $price = (int)get_query_var('price');
    if ($price) {
        $meta_query = $query->get('meta_query', []);
        $meta_query[] = [
            'key' => 'price',
            'value' => $price,
            'compare' => '<=',
            'type' => 'NUMERIC'
        ];
        $query->set('meta_query', $meta_query);
    }
});

add_action('init', function () use (&$propertyCategories): void {
    $propertyCategories = [
        _x('buy', 'URL', 'agence') => 'buy',
        _x('rent', 'URL', 'agence') => 'rent',
    ];
    add_rewrite_rule(
        _x('property', 'URL', 'agence') . '/(' . implode('|', array_keys($propertyCategories)) . ')/?$',
        'index.php?post_type=property&property_category=$matches[1]',
        'top'
    );
});

add_filter('nav_menu_css_class', function (array $classes, WP_Post $item): array {
    if (is_post_type_archive('property')) {
        global $wp;
        if ($wp->request == trim($item->url, '/')) {
            $classes[] = 'current-page-parent';
        }
    }

    if (is_singular('property') && function_exists('get_field')) {
        $property = get_queried_object();
        $category = get_field('property_category', $property);
        if ($category == 'buy') {
            $condition = _x('buy', 'URL', 'agence');
        } else {
            $condition = _x('rent', 'URL', 'agence');
        }
        if ($condition == true) {
            $classes[] = 'current-page-parent';
        }
    }
    return $classes;
}, 10, 2);

function agencia_is_rent_url(string $url): bool
{
    return strpos($url, _x('property', 'URL', 'agence') . '/' . _x('rent', 'URL', 'agence')) !== false;
}

function agencia_is_buy_url(string $url): bool
{
    return strpos($url, _x('property', 'URL', 'agence') . '/' . _x('buy', 'URL', 'agence')) !== false;
}
