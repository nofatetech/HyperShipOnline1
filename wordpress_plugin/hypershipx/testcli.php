#!/usr/bin/env php
<?php

class CliApp {
    private $running = true;
    private $categories = [
        'Technology',
        'Science',
        'Sports',
        'Music',
        'Movies',
    ];

    private $products = [
        'Technology' => [
            ['name' => 'iPhone 15 Pro', 'price' => '$999', 'description' => 'Latest Apple smartphone with advanced camera system'],
            ['name' => 'MacBook Air M2', 'price' => '$1199', 'description' => 'Ultra-thin laptop with powerful M2 chip'],
            ['name' => 'Sony WH-1000XM5', 'price' => '$399', 'description' => 'Premium noise-cancelling headphones'],
            ['name' => 'Samsung Galaxy S24', 'price' => '$799', 'description' => 'Android flagship with AI features'],
            ['name' => 'iPad Pro 12.9"', 'price' => '$1099', 'description' => 'Professional tablet for creative work'],
        ],
        'Science' => [
            ['name' => 'Microscope Set', 'price' => '$89', 'description' => 'Educational microscope for home use'],
            ['name' => 'Chemistry Kit', 'price' => '$45', 'description' => 'Safe chemistry experiments for beginners'],
            ['name' => 'Telescope 70mm', 'price' => '$129', 'description' => 'Beginner telescope for stargazing'],
            ['name' => 'DNA Model Kit', 'price' => '$25', 'description' => 'Educational DNA structure model'],
            ['name' => 'Physics Lab Set', 'price' => '$67', 'description' => 'Basic physics experiments kit'],
        ],
        'Sports' => [
            ['name' => 'Nike Air Max', 'price' => '$130', 'description' => 'Comfortable running shoes with air cushioning'],
            ['name' => 'Wilson Tennis Racket', 'price' => '$89', 'description' => 'Professional tennis racket for intermediate players'],
            ['name' => 'Yoga Mat Premium', 'price' => '$35', 'description' => 'Non-slip yoga mat with carrying strap'],
            ['name' => 'Basketball Official Size', 'price' => '$45', 'description' => 'Official size basketball for indoor/outdoor use'],
            ['name' => 'Fitness Tracker', 'price' => '$79', 'description' => 'Smart fitness band with heart rate monitor'],
        ],
        'Music' => [
            ['name' => 'Fender Stratocaster', 'price' => '$699', 'description' => 'Classic electric guitar for rock music'],
            ['name' => 'Yamaha Piano Keyboard', 'price' => '$299', 'description' => '88-key digital piano with weighted keys'],
            ['name' => 'Shure SM58 Microphone', 'price' => '$99', 'description' => 'Professional vocal microphone'],
            ['name' => 'Bose SoundLink', 'price' => '$199', 'description' => 'Portable Bluetooth speaker with deep bass'],
            ['name' => 'Metronome Digital', 'price' => '$25', 'description' => 'Digital metronome for practice sessions'],
        ],
        'Movies' => [
            ['name' => 'Blu-ray Player 4K', 'price' => '$149', 'description' => '4K Ultra HD Blu-ray player with streaming'],
            ['name' => 'Home Theater System', 'price' => '$399', 'description' => '5.1 surround sound system for movies'],
            ['name' => 'Movie Collection Box Set', 'price' => '$89', 'description' => 'Classic movie collection on Blu-ray'],
            ['name' => 'Projector HD', 'price' => '$299', 'description' => 'HD projector for home cinema experience'],
            ['name' => 'Popcorn Machine', 'price' => '$45', 'description' => 'Home popcorn machine for movie nights'],
        ],
    ];

    private $selectedIndex = 0;
    private $selectedProductIndex = 0;
    private $currentView = 'categories'; // 'categories', 'products', 'product_detail'
    private $currentCategory = '';

    public function run() {
        // Enable raw mode for reading arrow keys
        system('stty -icanon -echo');

        while ($this->running) {
            switch ($this->currentView) {
                case 'categories':
                    $this->showCategoryScreen();
                    break;
                case 'products':
                    $this->showProductScreen();
                    break;
                case 'product_detail':
                    $this->showProductDetailScreen();
                    break;
            }
        }

        // Restore terminal settings
        system('stty icanon echo');
    }

    private function showCategoryScreen() {
        $this->clearScreen();
        echo "=== Category Selector ===\n\n";
        echo "Use arrow keys to navigate, Enter to select, q to quit\n\n";

        foreach ($this->categories as $index => $category) {
            $prefix = ($index === $this->selectedIndex) ? "> " : "  ";
            echo "$prefix$category\n";
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
                $this->currentCategory = $this->categories[$this->selectedIndex];
                $this->selectedProductIndex = 0;
                $this->currentView = 'products';
                break;
            case 'q':
            case 'Q':
                $this->running = false;
                $this->clearScreen();
                echo "Thank you for using Category Selector!\n";
                break;
        }
    }

    private function showProductScreen() {
        $this->clearScreen();
        echo "=== {$this->currentCategory} Products ===\n\n";
        echo "Use arrow keys to navigate, Enter to select, ESC to go back, q to quit\n\n";

        $categoryProducts = $this->products[$this->currentCategory] ?? [];

        foreach ($categoryProducts as $index => $product) {
            $prefix = ($index === $this->selectedProductIndex) ? "> " : "  ";
            echo "$prefix{$product['name']} - {$product['price']}\n";
        }

        $key = $this->getKeyPress();

        switch ($key) {
            case "\033[A": // Up arrow
                $this->selectedProductIndex = max(0, $this->selectedProductIndex - 1);
                break;
            case "\033[B": // Down arrow
                $this->selectedProductIndex = min(count($categoryProducts) - 1, $this->selectedProductIndex + 1);
                break;
            case "\n": // Enter
                if (!empty($categoryProducts)) {
                    $this->currentView = 'product_detail';
                }
                break;
            case "\033": // ESC key
                $this->currentView = 'categories';
                break;
            case 'q':
            case 'Q':
                $this->running = false;
                $this->clearScreen();
                echo "Thank you for using Category Selector!\n";
                break;
        }
    }

    private function showProductDetailScreen() {
        $this->clearScreen();
        $categoryProducts = $this->products[$this->currentCategory] ?? [];
        $product = $categoryProducts[$this->selectedProductIndex] ?? null;

        if ($product) {
            echo "=== Product Details ===\n\n";
            echo "Name: {$product['name']}\n";
            echo "Price: {$product['price']}\n";
            echo "Category: {$this->currentCategory}\n";
            echo "Description: {$product['description']}\n\n";

            echo "Features:\n";
            echo "- High quality product\n";
            echo "- Fast shipping available\n";
            echo "- 30-day return policy\n";
            echo "- Customer support included\n\n";

            echo "Press ESC to go back to products, q to quit\n";
        }

        $key = $this->getKeyPress();

        switch ($key) {
            case "\033": // ESC key
                $this->currentView = 'products';
                break;
            case 'q':
            case 'Q':
                $this->running = false;
                $this->clearScreen();
                echo "Thank you for using Category Selector!\n";
                break;
        }
    }

    private function getKeyPress() {
        // Read a single character without echo
        $handle = fopen("php://stdin", "r");
        $char = fread($handle, 3); // Read up to 3 bytes for arrow keys
        fclose($handle);
        return $char;
    }

    private function clearScreen() {
        echo PHP_OS_FAMILY === 'Windows' ? `cls` : `clear`;
    }
}

$app = new CliApp();
$app->run();
?>