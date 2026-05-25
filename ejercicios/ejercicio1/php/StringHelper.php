<?php

class StringHelper 
{
    public static function truncate(string $text, int $maxLength, string $suffix = "..."): string 
    {
        if ($maxLength <= 0) {
            throw new \InvalidArgumentException("El maxLength debe ser mayor a 0");
        }
        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }
        return mb_substr($text, 0, $maxLength) . $suffix;
    }

    public static function toSlug(string $text): string 
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = trim($text);
        return preg_replace('/\s+/', '-', $text);
    }

    public static function countWords(string $text): int 
    {
        if (trim($text) === '') {
            return 0;
        }
        $words = preg_split('/\s+/', trim($text));
        return count($words);
    }
}