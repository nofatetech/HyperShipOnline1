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
        echo "Use arrow keys to navigate, Enter to select, q to quit\n\n";

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
            case 'q':
            case 'Q':
                $this->running = false;
                $this->clearScreen();
                echo "Thank you for using WooCommerce Category Selector!\n";
                break;
        }
    }

    private function showCategoryDetails($category) {
        $this->clearScreen();
        echo "=== {$category->name} ===\n\n";
        echo "Details for Category ID: {$category->term_id}\n";
        echo "Name: {$category->name}\n";
        echo "Slug: {$category->slug}\n";
        echo "Description: {$category->description}\n";
        echo "Product Count: {$category->count}\n\n";
        echo "Press any key to return to main menu...\n";
        $this->getKeyPress();
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