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

    // Flashy header with colors and borders
    echo "\033[1;36m"; // Bright cyan
    echo "╔══════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                                                                              ║\n";
    echo "║                    🛍️  WELCOME TO {$store_name} 🛍️                    ║\n";
    echo "║                                                                              ║\n";
    if (!empty($store_description)) {
        echo "║                        {$store_description}                        ║\n";
        echo "║                                                                              ║\n";
    }
    echo "╚══════════════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m"; // Reset colors

    // Get products on sale
    $products_on_sale = wc_get_products([
        'status' => 'publish',
        'limit' => 10,
        'on_sale' => true,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    echo "\n";
    echo "\033[1;33m"; // Bright yellow
    echo "🔥🔥🔥  HOT DEALS - PRODUCTS ON SALE! 🔥🔥🔥\n";
    echo "\033[0m";

    if (empty($products_on_sale)) {
        echo "\033[1;31m"; // Bright red
        echo "❌ No products currently on sale.\n";
        echo "\033[0m";
    } else {
        echo "\033[1;32m"; // Bright green
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "\033[0m";

        foreach ($products_on_sale as $index => $product) {
            $prefix = ($index === 0) ? "\033[1;33m▶ " : "\033[0m  ";
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $discount = $regular_price && $sale_price ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;

            echo $prefix;
            echo "\033[1;37m{$product->get_name()}\033[0m\n";
            echo "   💰 \033[1;32m\${$sale_price}\033[0m (was \033[1;31m\${$regular_price}\033[0m) ";
            echo "\033[1;33m🎉 {$discount}% OFF! 🎉\033[0m\n";
            echo "\n";
        }
    }

    // Get latest blog posts
    $latest_posts = get_posts([
        'numberposts' => 5,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    echo "\033[1;35m"; // Bright magenta
    echo "📝📝📝  LATEST BLOG POSTS & NEWS 📝📝📝\n";
    echo "\033[0m";

    if (empty($latest_posts)) {
        echo "\033[1;31m"; // Bright red
        echo "❌ No blog posts found.\n";
        echo "\033[0m";
    } else {
        echo "\033[1;32m"; // Bright green
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "\033[0m";

        foreach ($latest_posts as $index => $post) {
            $prefix = ($index === 0) ? "\033[1;35m▶ " : "\033[0m  ";
            $date = get_the_date('M j, Y', $post->ID);

            echo $prefix;
            echo "\033[1;37m{$post->post_title}\033[0m\n";
            echo "   📅 \033[1;36m{$date}\033[0m\n";
            echo "\n";
        }
    }

    echo "\033[1;34m"; // Bright blue
    echo "📂📂📂  BROWSE PRODUCT CATEGORIES 📂📂📂\n";
    echo "\033[0m";
    echo "\033[1;32m"; // Bright green
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "\033[0m";
    echo "  🛒 View all product categories and discover amazing products!\n\n";

    echo "\033[1;33m"; // Bright yellow
    echo "🎮 NAVIGATION: Use ↑↓ arrow keys to navigate, Enter to select, ESC to quit 🎮\n";
    echo "\033[0m";

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
 * @param array $cart Current cart contents
 * @return int Selected item index
 */
function display_home_screen_with_selection($data, $selectedIndex = 0, $cart = []) {
    $store_name = get_bloginfo('name');
    $store_description = get_bloginfo('description');

    // Flashy header with colors and borders
    echo "\033[1;36m"; // Bright cyan
    echo "╔══════════════════════════════════════════════════════════════════════════════╗\n";
    echo "║                                                                              ║\n";
    echo "║                    🛍️  WELCOME TO {$store_name} 🛍️                    ║\n";
    echo "║                                                                              ║\n";
    if (!empty($store_description)) {
        echo "║                        {$store_description}                        ║\n";
        echo "║                                                                              ║\n";
    }
    echo "╚══════════════════════════════════════════════════════════════════════════════╝\n";
    echo "\033[0m"; // Reset colors

    $products_on_sale = $data['products_on_sale'];
    $latest_posts = $data['latest_posts'];

    $total_items = count($products_on_sale) + count($latest_posts) + 1; // +1 for categories option

    echo "\n";
    echo "\033[1;33m"; // Bright yellow
    echo "🔥🔥🔥  HOT DEALS - PRODUCTS ON SALE! 🔥🔥🔥\n";
    echo "\033[0m";

    if (empty($products_on_sale)) {
        echo "\033[1;31m"; // Bright red
        echo "❌ No products currently on sale.\n";
        echo "\033[0m";
    } else {
        echo "\033[1;32m"; // Bright green
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "\033[0m";

        foreach ($products_on_sale as $index => $product) {
            $prefix = ($index === $selectedIndex) ? "\033[1;33m▶ " : "\033[0m  ";
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $discount = $regular_price && $sale_price ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;

            // Get cart quantity for this product
            $product_id = $product->get_id();
            $cart_qty = isset($cart[$product_id]) ? $cart[$product_id] : 0;

            // Cart indicators
            $cart_indicator = "";
            if ($cart_qty > 0) {
                $cart_indicator = "\033[1;32m [+{$cart_qty}]\033[0m";
            }

            // Add/remove indicators for selected product
            if ($index === $selectedIndex) {
                $cart_indicator .= " \033[1;33m[← -] [→ +]\033[0m";
            }

            echo $prefix;
            echo "\033[1;37m{$product->get_name()}\033[0m{$cart_indicator}\n";
            echo "   💰 \033[1;32m\${$sale_price}\033[0m (was \033[1;31m\${$regular_price}\033[0m) ";
            echo "\033[1;33m🎉 {$discount}% OFF! 🎉\033[0m\n";
            echo "\n";
        }
    }

    echo "\033[1;35m"; // Bright magenta
    echo "📝📝📝  LATEST BLOG POSTS & NEWS 📝📝📝\n";
    echo "\033[0m";

    if (empty($latest_posts)) {
        echo "\033[1;31m"; // Bright red
        echo "❌ No blog posts found.\n";
        echo "\033[0m";
    } else {
        echo "\033[1;32m"; // Bright green
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "\033[0m";

        foreach ($latest_posts as $index => $post) {
            $prefix = ($index + count($products_on_sale) === $selectedIndex) ? "\033[1;35m▶ " : "\033[0m  ";
            $date = get_the_date('M j, Y', $post->ID);

            echo $prefix;
            echo "\033[1;37m{$post->post_title}\033[0m\n";
            echo "   📅 \033[1;36m{$date}\033[0m\n";
            echo "\n";
        }
    }

    echo "\033[1;34m"; // Bright blue
    echo "📂📂📂  BROWSE PRODUCT CATEGORIES 📂📂📂\n";
    echo "\033[0m";
    echo "\033[1;32m"; // Bright green
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "\033[0m";

    $categories_index = count($products_on_sale) + count($latest_posts);
    $prefix = ($categories_index === $selectedIndex) ? "\033[1;34m▶ " : "\033[0m  ";
    echo $prefix;
    echo "🛒 View all product categories and discover amazing products!\n\n";

    // Show cart summary
    $total_items_in_cart = array_sum($cart);
    if ($total_items_in_cart > 0) {
        echo "\033[1;32m"; // Bright green
        echo "🛒 CART SUMMARY: {$total_items_in_cart} items in cart\033[0m\n";
        echo "\n";
    }

    echo "\033[1;33m"; // Bright yellow
    echo "🎮 NAVIGATION: ↑↓ navigate, ←→ add/remove from cart, Enter select, ESC quit 🎮\n";
    echo "\033[0m";

    return $selectedIndex;
}