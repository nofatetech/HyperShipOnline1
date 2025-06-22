<?php
/**
 * Home Screen View
 *
 * Displays store information, products on sale, and latest blog posts
 *
 * @return array Array containing products on sale and blog posts
 */
function display_home_screen() {
    // Get store information
    $store_name = get_bloginfo('name');
    $store_description = get_bloginfo('description');

    echo "=== {$store_name} ===\n";
    if (!empty($store_description)) {
        echo "{$store_description}\n";
    }
    echo "================================\n\n";

    // Get products on sale
    $products_on_sale = wc_get_products([
        'status' => 'publish',
        'limit' => 10,
        'on_sale' => true,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    echo "🔥 Products on Sale:\n";
    if (empty($products_on_sale)) {
        echo "No products currently on sale.\n\n";
    } else {
        foreach ($products_on_sale as $index => $product) {
            $prefix = ($index === 0) ? "> " : "  ";
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $discount = $regular_price && $sale_price ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;
            echo "$prefix{$product->get_name()} - \${$sale_price} (was \${$regular_price}) - {$discount}% off\n";
        }
    }

    // Get latest blog posts
    $latest_posts = get_posts([
        'numberposts' => 5,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    echo "\n📝 Latest Blog Posts:\n";
    if (empty($latest_posts)) {
        echo "No blog posts found.\n\n";
    } else {
        foreach ($latest_posts as $index => $post) {
            $prefix = ($index === 0) ? "> " : "  ";
            $date = get_the_date('M j, Y', $post->ID);
            echo "$prefix{$post->post_title} - {$date}\n";
        }
    }

    echo "\n📂 Browse Categories\n";
    echo "  View all product categories\n\n";

    echo "Navigation: Use arrow keys to navigate, Enter to select, ESC to quit\n";

    return [
        'products_on_sale' => $products_on_sale,
        'latest_posts' => $latest_posts
    ];
}

/**
 * Display home screen with selection
 *
 * @param array $data Array containing products on sale and blog posts
 * @param int $selectedIndex Currently selected item index
 * @return int Selected item index
 */
function display_home_screen_with_selection($data, $selectedIndex = 0) {
    $store_name = get_bloginfo('name');
    $store_description = get_bloginfo('description');

    echo "=== {$store_name} ===\n";
    if (!empty($store_description)) {
        echo "{$store_description}\n";
    }
    echo "================================\n\n";

    $products_on_sale = $data['products_on_sale'];
    $latest_posts = $data['latest_posts'];

    $total_items = count($products_on_sale) + count($latest_posts) + 1; // +1 for categories option

    echo "🔥 Products on Sale:\n";
    if (empty($products_on_sale)) {
        echo "No products currently on sale.\n\n";
    } else {
        foreach ($products_on_sale as $index => $product) {
            $prefix = ($index === $selectedIndex) ? "> " : "  ";
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $discount = $regular_price && $sale_price ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;
            echo "$prefix{$product->get_name()} - \${$sale_price} (was \${$regular_price}) - {$discount}% off\n";
        }
    }

    echo "\n📝 Latest Blog Posts:\n";
    if (empty($latest_posts)) {
        echo "No blog posts found.\n\n";
    } else {
        foreach ($latest_posts as $index => $post) {
            $prefix = ($index + count($products_on_sale) === $selectedIndex) ? "> " : "  ";
            $date = get_the_date('M j, Y', $post->ID);
            echo "$prefix{$post->post_title} - {$date}\n";
        }
    }

    echo "\n📂 Browse Categories\n";
    $categories_index = count($products_on_sale) + count($latest_posts);
    $prefix = ($categories_index === $selectedIndex) ? "> " : "  ";
    echo "$prefix View all product categories\n\n";

    echo "Navigation: Use arrow keys to navigate, Enter to select, ESC to quit\n";

    return $selectedIndex;
}