<?php
/**
 * Product Details View
 *
 * Displays detailed information about a WooCommerce product
 *
 * @param WC_Product $product The product object to display
 */
function display_product_details($product) {
    echo "=== {$product->get_name()} ===\n\n";
    echo "Product ID: {$product->get_id()}\n";
    echo "SKU: " . ($product->get_sku() ?: 'N/A') . "\n";
    echo "Type: {$product->get_type()}\n";
    echo "Status: {$product->get_status()}\n";
    echo "Price: $" . ($product->get_price() ?: 'N/A') . "\n";
    echo "Regular Price: $" . ($product->get_regular_price() ?: 'N/A') . "\n";
    echo "Sale Price: $" . ($product->get_sale_price() ?: 'N/A') . "\n";
    echo "Stock Status: {$product->get_stock_status()}\n";
    echo "Stock Quantity: " . ($product->get_stock_quantity() ?: 'N/A') . "\n";
    echo "Weight: " . ($product->get_weight() ?: 'N/A') . "\n";
    echo "Dimensions: " . ($product->get_length() ?: 'N/A') . " x " . ($product->get_width() ?: 'N/A') . " x " . ($product->get_height() ?: 'N/A') . "\n";
    echo "Virtual: " . ($product->is_virtual() ? 'Yes' : 'No') . "\n";
    echo "Downloadable: " . ($product->is_downloadable() ? 'Yes' : 'No') . "\n";
    echo "Featured: " . ($product->get_featured() ? 'Yes' : 'No') . "\n";
    echo "Average Rating: " . ($product->get_average_rating() ?: 'N/A') . "\n";
    echo "Review Count: " . ($product->get_review_count() ?: '0') . "\n\n";

    // Description
    $description = $product->get_description();
    if (!empty($description)) {
        echo "Description:\n";
        echo wordwrap($description, 80) . "\n\n";
    }

    // Short description
    $short_description = $product->get_short_description();
    if (!empty($short_description)) {
        echo "Short Description:\n";
        echo wordwrap($short_description, 80) . "\n\n";
    }

    // Categories
    $categories = wc_get_product_category_list($product->get_id());
    if (!empty($categories)) {
        echo "Categories: {$categories}\n\n";
    }

    // Tags
    $tags = wc_get_product_tag_list($product->get_id());
    if (!empty($tags)) {
        echo "Tags: {$tags}\n\n";
    }

    echo "Press ESC to return to product list...\n";
}