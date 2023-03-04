<?php
defined('ABSPATH') or die('Rien à voir');

add_action('template_redirect', function () {
    if (is_post_type_archive('property')) {
        $authorizedValue = [
            agencia_plugin_buy_route_name(),
            agencia_plugin_rent_route_name()
        ];
        if (isset($_GET['property_category']) && in_array($_GET['property_category'], $authorizedValue)) {
            $filteredParams = [];
            foreach ($_GET as $key => $value) {
                if ($key !== 'property_category' && $key != '') {
                    $filteredParams[$key] = $value;
                }
            }

            wp_redirect('/' . _x('property', 'URL', 'agence') . '/' . $_GET['property_category'] . '?' . http_build_query($filteredParams));
            exit();
        }
    }
});
