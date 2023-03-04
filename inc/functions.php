<?php

/**
 * Show city and postal code associated to a property
 * @param WP_Post|int|null $post
 */
function agencia_plugin_city($post = null): void
{
    if ($post === null) {
        $post = get_post();
    }
    $cities = get_the_terms($post, 'property_city');
    if (empty($cities)) {
        return;
    }
    $city = $cities[0];
    echo $city->name;
    $postalCode = get_field('postal_code', $city);
    if ($postalCode) {
        echo ' (' . $postalCode . ')';
    }
}

/**
 * Show price of a property
 * @param WP_Post|int|null $post
 */
function agencia_plugin_price($post = null)
{
    if (get_field('property_category', $post) == 'buy') {
        echo sprintf('%s €', number_format_i18n(get_field('price', $post)));
    } else {
        echo sprintf('%s €/mois', number_format_i18n(get_field('price', $post)));
    }
}

function agencia_plugin_rent_route_name()
{
    return _x('rent', 'URL', 'agence');
}
function agencia_plugin_buy_route_name()
{
    return _x('buy', 'URL', 'agence');
}
