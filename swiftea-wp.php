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

// Admin page

add_action('admin_menu', 'setup_menu');

function setup_menu()
{
    add_menu_page('Swiftea', 'Swiftea', 'manage_options', 'swiftea', 'init_admin', plugin_dir_url( __FILE__ ) . 'assets/menu-icon.png');
}

function init_admin()
{
    echo '<br><img src="' . plugin_dir_url( __FILE__ ) . 'assets/logo-112x35.png">';
    echo '<h1>Drive research of your website!</h1>';
    echo '<h2>Usage</h2>';

    echo '<p>To add search functionality to your site, use this shortcode where you want to add the search form:</p>';
    echo '<pre><code>[swiftea]</code></pre>';
}

// Search form shortcode

function generate_shortcode($atts) {
    $content = '
    <form method="GET" action="https://swifteasearch.alwaysdata.net/internal-search-result" class="search-form">
        <input type="search" name="q" placeholder="Your search" required class="search-field">
        <input type="hidden" name="d" value="' . get_bloginfo('url') . '">
        <button type="submit" class="search-submit">GO!</button>
    </form>';
    return $content;
}

add_shortcode('swiftea', 'generate_shortcode');