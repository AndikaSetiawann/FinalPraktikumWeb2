<?php

if (!function_exists('format_text_content')) {
    /**
     * Format text content with basic markdown-style formatting
     * Supports: **bold**, *italic*, __underline__, and line breaks
     * 
     * @param string $text The text to format
     * @return string Formatted HTML text
     */
    function format_text_content($text) {
        if (empty($text)) {
            return '';
        }
        
        // First escape HTML for security
        $formatted = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        
        // Use temporary placeholders to avoid regex conflicts
        
        // Bold: **text** -> <strong>text</strong>
        $formatted = preg_replace('/\*\*([^\*\r\n]+)\*\*/', '___BOLD_START___$1___BOLD_END___', $formatted);
        
        // Italic: *text* -> <em>text</em> (single asterisk, not double)
        $formatted = preg_replace('/\*([^\*\r\n]+)\*/', '___ITALIC_START___$1___ITALIC_END___', $formatted);
        
        // Underline: __text__ -> <u>text</u>
        $formatted = preg_replace('/__([^_\r\n]+)__/', '___UNDERLINE_START___$1___UNDERLINE_END___', $formatted);
        
        // Replace placeholders with actual HTML tags
        $formatted = str_replace([
            '___BOLD_START___', '___BOLD_END___',
            '___ITALIC_START___', '___ITALIC_END___',
            '___UNDERLINE_START___', '___UNDERLINE_END___'
        ], [
            '<strong>', '</strong>',
            '<em>', '</em>',
            '<u>', '</u>'
        ], $formatted);
        
        // Convert line breaks to <br>
        $formatted = nl2br($formatted);
        
        return $formatted;
    }
}
