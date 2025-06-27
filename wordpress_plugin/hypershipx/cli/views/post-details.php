<?php
/**
 * Post Details View
 *
 * Displays detailed information about a blog post
 *
 * @param WP_Post $post The post object to display
 */
function display_post_details($post) {
    echo "=== {$post->post_title} ===\n\n";
    echo "Post ID: {$post->ID}\n";
    echo "Author: " . get_the_author_meta('display_name', $post->post_author) . "\n";
    echo "Published: " . get_the_date('F j, Y g:i A', $post->ID) . "\n";
    echo "Status: {$post->post_status}\n";
    echo "Type: {$post->post_type}\n";

    // Categories
    $categories = get_the_category($post->ID);
    if (!empty($categories)) {
        $category_names = array_map(function($cat) { return $cat->name; }, $categories);
        echo "Categories: " . implode(', ', $category_names) . "\n";
    }

    // Tags
    $tags = get_the_tags($post->ID);
    if (!empty($tags)) {
        $tag_names = array_map(function($tag) { return $tag->name; }, $tags);
        echo "Tags: " . implode(', ', $tag_names) . "\n";
    }

    echo "\n";

    // Content
    $content = wp_strip_all_tags($post->post_content);
    if (!empty($content)) {
        echo "Content:\n";
        echo wordwrap($content, 80) . "\n\n";
    }

    // Excerpt
    $excerpt = $post->post_excerpt;
    if (!empty($excerpt)) {
        echo "Excerpt:\n";
        echo wordwrap($excerpt, 80) . "\n\n";
    }

    echo "Press ESC to return to home screen...\n";
}