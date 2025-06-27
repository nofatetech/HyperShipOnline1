#!/usr/bin/env php
<?php

// Bootstrap WordPress
if (!defined('ABSPATH')) {
    // Adjust path to wp-load.php based on your server structure
    $wp_load = dirname(__FILE__, 4) . '/wp-load.php';
    if (file_exists($wp_load)) {
        include_once $wp_load;
    } else {
        die("Error: Could not load WordPress.\n");
    }
}

// Ensure WooCommerce is active
if (!class_exists('WooCommerce')) {
    die("Error: WooCommerce is not active.\n");
}

/**
 * WooCommerce CLI Application
 *
 * A command-line interface for browsing WooCommerce products and categories
 */
class WooCommerceCliApp
{
    private $_running = true;
    private $_categories = [];
    private $_selectedIndex = 0;
    private $_homeData = [];
    private $_cart = [];

    public function __construct()
    {
        // Fetch WooCommerce product categories
        $this->_categories = $this->_getWooCommerceCategories();
        $this->_loadCart();
    }

    public function run()
    {
        // Enable raw mode for reading arrow keys
        system('stty -icanon -echo');

        while ($this->_running) {
            $this->_showHomeScreen();
        }

        // Restore terminal settings
        system('stty icanon echo');
    }

    private function _showHomeScreen()
    {
        $this->_clearScreen();

        // Include the home screen view file
        include_once dirname(__FILE__) . '/views/home-screen.php';

        // Get home screen data
        $this->_homeData = display_home_screen();

        // Handle home screen navigation
        $this->_showHomeScreenNavigation();
    }

    private function _showHomeScreenNavigation()
    {
        $selectedIndex = 0;
        $products_on_sale = $this->_homeData['products_on_sale'];
        $latest_posts = $this->_homeData['latest_posts'];
        $total_items = count($products_on_sale) + count($latest_posts) + 1; // +1 for categories option

        while (true) {
            $this->_clearScreen();

            // Include the home screen view file
            include_once dirname(__FILE__) . '/views/home-screen.php';

            // Display home screen with selection
            display_home_screen_with_selection($this->_homeData, $selectedIndex, $this->_cart);

            $key = $this->_getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $selectedIndex = max(0, $selectedIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $selectedIndex = min($total_items - 1, $selectedIndex + 1);
                    break;
                case "\033[C": // Right arrow - add to cart
                    if ($selectedIndex < count($products_on_sale)) {
                        $this->_addToCart($products_on_sale[$selectedIndex]);
                    }
                    break;
                case "\033[D": // Left arrow - remove from cart
                    if ($selectedIndex < count($products_on_sale)) {
                        $this->_removeFromCart($products_on_sale[$selectedIndex]);
                    }
                    break;
                case "\n": // Enter
                    $this->_handleHomeScreenSelection($selectedIndex);
                    break;
                case "\033": // ESC key
                    $this->_running = false;
                    $this->_clearScreen();
                    echo "Thank you for using WooCommerce CLI!\n";
                    break;
            }
        }
    }

    private function _addToCart($product)
    {
        $product_id = $product->get_id();
        if (!isset($this->_cart[$product_id])) {
            $this->_cart[$product_id] = 0;
        }
        $this->_cart[$product_id]++;
        $this->_saveCart();
    }

    private function _removeFromCart($product)
    {
        $product_id = $product->get_id();
        if (isset($this->_cart[$product_id]) && $this->_cart[$product_id] > 0) {
            $this->_cart[$product_id]--;
            if ($this->_cart[$product_id] <= 0) {
                unset($this->_cart[$product_id]);
            }
            $this->_saveCart();
        }
    }

    private function _loadCart()
    {
        $cart_file = dirname(__FILE__) . '/cart.json';
        if (file_exists($cart_file)) {
            $cart_data = file_get_contents($cart_file);
            $this->_cart = json_decode($cart_data, true) ?: [];
        }
    }

    private function _saveCart()
    {
        $cart_file = dirname(__FILE__) . '/cart.json';
        file_put_contents($cart_file, json_encode($this->_cart));
    }

    private function _handleHomeScreenSelection($selectedIndex)
    {
        $products_on_sale = $this->_homeData['products_on_sale'];
        $latest_posts = $this->_homeData['latest_posts'];

        if ($selectedIndex < count($products_on_sale)) {
            // Selected a product on sale
            $this->_showProductDetails($products_on_sale[$selectedIndex]);
        } elseif ($selectedIndex < count($products_on_sale) + count($latest_posts)) {
            // Selected a blog post
            $post_index = $selectedIndex - count($products_on_sale);
            $this->_showPostDetails($latest_posts[$post_index]);
        } else {
            // Selected categories option
            $this->_showCategoriesScreen();
        }
    }

    private function _showPostDetails($post)
    {
        $this->_clearScreen();

        // Include the post details view file
        include_once dirname(__FILE__) . '/views/post-details.php';

        // Display post details
        display_post_details($post);

        // Wait for ESC key to go back
        while (true) {
            $key = $this->_getKeyPress();
            if ($key === "\033") { // ESC key
                break;
            }
        }
    }

    private function _showCategoriesScreen()
    {
        while (true) {
            $this->_clearScreen();
            echo "=== Browse Categories ===\n\n";
            echo "Use arrow keys to navigate, Enter to select, ESC to go back\n\n";

            foreach ($this->_categories as $index => $category) {
                $prefix = ($index === $this->_selectedIndex) ? "> " : "  ";
                echo "$prefix{$category->name} (ID: {$category->term_id})\n";
            }

            $key = $this->_getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $this->_selectedIndex = max(0, $this->_selectedIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $this->_selectedIndex = min(count($this->_categories) - 1, $this->_selectedIndex + 1);
                    break;
                case "\n": // Enter
                    $this->_showCategoryDetails($this->_categories[$this->_selectedIndex]);
                    break;
                case "\033": // ESC key
                    return; // Go back to home screen
                    break;
            }
        }
    }

    private function _showCategoryDetails($category)
    {
        $this->_clearScreen();

        // Include the view file
        include_once dirname(__FILE__) . '/views/category-details.php';

        // Get products and display category info
        $products = display_category_details($category);

        if (empty($products)) {
            $this->_getKeyPress();
            return;
        }

        // Handle product selection
        $this->_showProductList($products);
    }

    private function _showProductList($products)
    {
        $selectedProductIndex = 0;

        while (true) {
            $this->_clearScreen();

            // Include the view file
            include_once dirname(__FILE__) . '/views/category-details.php';

            // Display product list
            display_product_list($products, $selectedProductIndex);

            $key = $this->_getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $selectedProductIndex = max(0, $selectedProductIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $selectedProductIndex = min(count($products) - 1, $selectedProductIndex + 1);
                    break;
                case "\n": // Enter
                    $this->_showProductDetails($products[$selectedProductIndex]);
                    break;
                case "\033": // ESC key
                    return; // Go back to category list
                    break;
            }
        }
    }

    private function _showProductDetails($product)
    {
        $this->_clearScreen();

        // Include the product details view file
        include_once dirname(__FILE__) . '/views/product-details.php';

        // Display product details
        display_product_details($product);

        // Wait for ESC key to go back
        while (true) {
            $key = $this->_getKeyPress();
            if ($key === "\033") { // ESC key
                break;
            }
        }
    }

    private function _getWooCommerceCategories()
    {
        $terms = get_terms(
            [
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
            ]
        );

        if (is_wp_error($terms)) {
            die("Error: Could not fetch categories.\n");
        }

        return $terms;
    }

    private function _getKeyPress()
    {
        $handle = fopen("php://stdin", "r");
        $char = fread($handle, 3);
        fclose($handle);
        return $char;
    }

    private function _clearScreen()
    {
        echo PHP_OS_FAMILY === 'Windows' ? `cls` : `clear`;
    }
}

// $app = new WooCommerceCliApp();
// $app->run();