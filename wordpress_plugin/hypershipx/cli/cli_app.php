#!/usr/bin/env php
<?php

// Bootstrap WordPress
if (!defined('ABSPATH')) {
    // Adjust path to wp-load.php based on your server structure
    $wp_load = dirname(__FILE__, 4) . '/wp-load.php';
    if (file_exists($wp_load)) {
        require_once $wp_load;
    } else {
        die("Error: Could not load WordPress.\n");
    }
}

// Ensure WooCommerce is active
if (!class_exists('WooCommerce')) {
    die("Error: WooCommerce is not active.\n");
}

class WooCommerceCliApp {
    private $running = true;
    private $categories = [];
    private $selectedIndex = 0;
    private $homeData = [];

    public function __construct() {
        // Fetch WooCommerce product categories
        $this->categories = $this->getWooCommerceCategories();
    }

    public function run() {
        // Enable raw mode for reading arrow keys
        system('stty -icanon -echo');

        while ($this->running) {
            $this->showHomeScreen();
        }

        // Restore terminal settings
        system('stty icanon echo');
    }

    private function showHomeScreen() {
        $this->clearScreen();

        // Include the home screen view file
        require_once dirname(__FILE__) . '/views/home-screen.php';

        // Get home screen data
        $this->homeData = display_home_screen();

        // Handle home screen navigation
        $this->showHomeScreenNavigation();
    }

    private function showHomeScreenNavigation() {
        $selectedIndex = 0;
        $products_on_sale = $this->homeData['products_on_sale'];
        $latest_posts = $this->homeData['latest_posts'];
        $total_items = count($products_on_sale) + count($latest_posts) + 1; // +1 for categories option

        while (true) {
            $this->clearScreen();

            // Include the home screen view file
            require_once dirname(__FILE__) . '/views/home-screen.php';

            // Display home screen with selection
            display_home_screen_with_selection($this->homeData, $selectedIndex);

            $key = $this->getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $selectedIndex = max(0, $selectedIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $selectedIndex = min($total_items - 1, $selectedIndex + 1);
                    break;
                case "\n": // Enter
                    $this->handleHomeScreenSelection($selectedIndex);
                    break;
                case "\033": // ESC key
                    // die("!!!!!");
                    $this->running = false;
                    $this->clearScreen();
                    echo "Thank you for using WooCommerce CLI!\n";
                    break;
            }
        }
    }

    private function handleHomeScreenSelection($selectedIndex) {
        $products_on_sale = $this->homeData['products_on_sale'];
        $latest_posts = $this->homeData['latest_posts'];

        if ($selectedIndex < count($products_on_sale)) {
            // Selected a product on sale
            $this->showProductDetails($products_on_sale[$selectedIndex]);
        } elseif ($selectedIndex < count($products_on_sale) + count($latest_posts)) {
            // Selected a blog post
            $post_index = $selectedIndex - count($products_on_sale);
            $this->showPostDetails($latest_posts[$post_index]);
        } else {
            // Selected categories option
            $this->showCategoriesScreen();
        }
    }

    private function showPostDetails($post) {
        $this->clearScreen();

        // Include the post details view file
        require_once dirname(__FILE__) . '/views/post-details.php';

        // Display post details
        display_post_details($post);

        // Wait for ESC key to go back
        while (true) {
            $key = $this->getKeyPress();
            if ($key === "\033") { // ESC key
                break;
            }
        }
    }

    private function showCategoriesScreen() {
        while (true) {
            $this->clearScreen();
            echo "=== Browse Categories ===\n\n";
            echo "Use arrow keys to navigate, Enter to select, ESC to go back\n\n";

            foreach ($this->categories as $index => $category) {
                $prefix = ($index === $this->selectedIndex) ? "> " : "  ";
                echo "$prefix{$category->name} (ID: {$category->term_id})\n";
            }

            $key = $this->getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $this->selectedIndex = max(0, $this->selectedIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $this->selectedIndex = min(count($this->categories) - 1, $this->selectedIndex + 1);
                    break;
                case "\n": // Enter
                    $this->showCategoryDetails($this->categories[$this->selectedIndex]);
                    break;
                case "\033": // ESC key
                    return; // Go back to home screen
                    break;
            }
        }
    }

    private function showCategoryDetails($category) {
        $this->clearScreen();

        // Include the view file
        require_once dirname(__FILE__) . '/views/category-details.php';

        // Get products and display category info
        $products = display_category_details($category);

        if (empty($products)) {
            $this->getKeyPress();
            return;
        }

        // Handle product selection
        $this->showProductList($products);
    }

    private function showProductList($products) {
        $selectedProductIndex = 0;

        while (true) {
            $this->clearScreen();

            // Include the view file
            require_once dirname(__FILE__) . '/views/category-details.php';

            // Display product list
            display_product_list($products, $selectedProductIndex);

            $key = $this->getKeyPress();

            switch ($key) {
                case "\033[A": // Up arrow
                    $selectedProductIndex = max(0, $selectedProductIndex - 1);
                    break;
                case "\033[B": // Down arrow
                    $selectedProductIndex = min(count($products) - 1, $selectedProductIndex + 1);
                    break;
                case "\n": // Enter
                    $this->showProductDetails($products[$selectedProductIndex]);
                    break;
                case "\033": // ESC key
                    return; // Go back to category list
                    break;
            }
        }
    }

    private function showProductDetails($product) {
        $this->clearScreen();

        // Include the product details view file
        require_once dirname(__FILE__) . '/views/product-details.php';

        // Display product details
        display_product_details($product);

        // Wait for ESC key to go back
        while (true) {
            $key = $this->getKeyPress();
            if ($key === "\033") { // ESC key
                break;
            }
        }
    }

    private function getWooCommerceCategories() {
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        if (is_wp_error($terms)) {
            die("Error: Could not fetch categories.\n");
        }

        return $terms;
    }

    private function getKeyPress() {
        $handle = fopen("php://stdin", "r");
        $char = fread($handle, 3);
        fclose($handle);
        return $char;
    }

    private function clearScreen() {
        echo PHP_OS_FAMILY === 'Windows' ? `cls` : `clear`;
    }
}

// $app = new WooCommerceCliApp();
// $app->run();