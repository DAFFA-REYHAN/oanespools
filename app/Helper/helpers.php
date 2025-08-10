<?php

if (!function_exists('getCleanDescription')) {
    function getCleanDescription($html, $limit = 150) {
        // Remove tables completely
        $html = preg_replace('/<table[^>]*>.*?<\/table>/is', '', $html);

        // Remove script and style tags
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);

        // Convert images to simple text indicator or remove them
        $html = preg_replace('/<img[^>]*>/i', '[Gambar] ', $html);

        // Clean up extra whitespace
        $html = preg_replace('/\s+/', ' ', $html);

        // Get plain text for length check
        $plainText = strip_tags($html);

        // If text is longer than limit, truncate it
        if (strlen($plainText) > $limit) {
            // Try to cut at word boundary
            $truncated = substr($plainText, 0, $limit);
            $lastSpace = strrpos($truncated, ' ');
            if ($lastSpace !== false) {
                $truncated = substr($truncated, 0, $lastSpace);
            }

            // Convert back to basic HTML structure
            $html = '<p>' . htmlspecialchars($truncated) . '...</p>';
        }

        return $html;
    }
}