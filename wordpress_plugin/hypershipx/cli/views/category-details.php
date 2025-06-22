<?php
/**
 * Category Details View
 *
 * Displays detailed information about a WooCommerce product category
 * and allows selection of products within that category
 *
 * @param object $category The category object to display
 * @return array Array of products in the category
 */
function display_category_details($category) {
    echo "=== {$category->name} ===\n\n";
    echo "Details for Category ID: {$category->term_id}\n";
    echo "Name: {$category->name}\n";
    echo "Slug: {$category->slug}\n";
    echo "Description: {$category->description}\n";
    echo "Product Count: {$category->count}\n\n";

    // Get products in this category
    $products = wc_get_products([
        'category' => [$category->slug],
        'limit' => 50,
        'status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    if (empty($products)) {
        echo "No products found in this category.\n\n";
        echo "Press any key to return to main menu...\n";
        return [];
    }

    echo "Products in this category:\n";
    echo "Use arrow keys to navigate, Enter to select product, ESC to go back\n\n";

    return $products;
}

/**
 * Display product list for selection
 *
 * @param array $products Array of product objects
 * @param int $selectedIndex Currently selected product index
 * @return int Selected product index
 */
function display_product_list($products, $selectedIndex = 0) {
    foreach ($products as $index => $product) {
        $prefix = ($index === $selectedIndex) ? "> " : "  ";
        $price = $product->get_price() ? '$' . $product->get_price() : 'N/A';
        $stock = $product->get_stock_status();
        echo "$prefix{$product->get_name()} (ID: {$product->get_id()}) - {$price} - {$stock}\n";
    }

    echo "\nPress Enter to view product details, ESC to go back...\n";

    return $selectedIndex;
}