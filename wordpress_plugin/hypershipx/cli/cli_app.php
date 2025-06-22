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

    public function __construct() {
        // Fetch WooCommerce product categories
        $this->categories = $this->getWooCommerceCategories();
    }

    public function run() {
        // Enable raw mode for reading arrow keys
        system('stty -icanon -echo');

        while ($this->running) {
            $this->showIntroScreen();
        }

        // Restore terminal settings
        system('stty icanon echo');
    }

    private function showIntroScreen() {
        $this->clearScreen();
        echo "=== WooCommerce Category Selector ===\n\n";
        echo "Use arrow keys to navigate, Enter to select, ESC to quit\n\n";

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
                $this->running = false;
                $this->clearScreen();
                echo "Thank you for using WooCommerce Category Selector!\n";
                break;
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