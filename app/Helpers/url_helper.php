<?php

if (!function_exists('separate_url_params')) {

    /**
     * Separates the URL into segments and returns them as an array.
     *
     * @param string $url The URL to be parsed.
     * @return array Array of URL segments.
     */
    function separate_url_params($url) {
        // Analisa a URL e separa os parâmetros
        $parts = parse_url($url);
        $params = explode('/', trim($parts['path'], '/'));
        return $params;
    }

}