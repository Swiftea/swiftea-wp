<?php

/**
 * Plugin Name: Swiftea
 * Plugin URI: https://swifteasearch.alwaysdata.net
 * Description: Powerful internal search for your website
 * Version: 0.1
 * Author: Hugo Posnic, Nathan Seva
 */

// Security

defined('ABSPATH') or die('No script kiddies please!');

// CSS

function swiftea_load_plugin_css() {
    wp_enqueue_style('swiftea_style', plugin_dir_url( __FILE__ ) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'swiftea_load_plugin_css');

// Admin page

add_action('admin_menu', 'swiftea_setup_menu');

function swiftea_setup_menu()
{
    add_menu_page('Swiftea', 'Swiftea', 'manage_options', 'swiftea', 'swiftea_init_admin', plugin_dir_url( __FILE__ ) . 'assets/menu-icon.png');
}

function swiftea_init_admin()
{
    echo '<br><img src="' . plugin_dir_url( __FILE__ ) . 'assets/logo-112x35.png">';
    echo '<h1>Drive research of your website!</h1>';
    echo '<h2>Usage</h2>';

    echo '<p>To add search functionality to your site, use this shortcode where you want to add the search form:</p>';
    echo '<pre><code>[swiftea]</code></pre>';

    echo '<p>To view results, add this shortcode in a page with the slug "swiftea-search":</p>';
    echo '<pre><code>[swiftea_results]</code></pre>';
}

// Search form request

add_action('admin_post_swiftea_search', 'swiftea_swiftea_search');

function swiftea_swiftea_search() {
    
}

// Search form results

function swiftea_generate_results() {
    if (isset($_GET['q'])) {
        $json = file_get_contents('https://swifteasearch.alwaysdata.net/json-search.php?q=' . $_GET['q'] . '&d=' . get_bloginfo('url'));
        $results = json_decode($json);
        $html = '<section id="swiftea-results">';
        foreach ($results as $result) {
            if (empty($result->favicon)) {
                $result->favicon = 'https://swifteasearch.alwaysdata.net/assets/img/default-favicon.png';
            }
            $html .= '
            <div class="result">
                <p class="result-title">
                <img src="' . $result->favicon . '" alt="">
                <a href="' . $result->url . '">' . $result->title . '</a>
                </p>
                <p class="result-description">' . $result->description . '</p>
                <p class="result-url">' . $result->url . '</p>
            </div>';
        }
        $html .= '</section>';
    }
    else {
        $html = '<p>Please make a search to view some results.</p>';
    }
    return $html;
}

add_shortcode('swiftea_results', 'swiftea_generate_results');

// Search form shortcode

function swiftea_generate_form() {
    $content = '
    <form method="GET" action="' . get_bloginfo('url') . '/swiftea-search" class="search-form">
        <input type="search" name="q" placeholder="Your search" required class="search-field">
        <button type="submit" class="search-submit">GO!</button>
    </form>';
    return $content;
}

add_shortcode('swiftea', 'swiftea_generate_form');