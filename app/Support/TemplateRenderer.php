<?php

namespace App\Support;

class TemplateRenderer
{
    public static function render(string $content, array $data): string
    {
        return (string) preg_replace_callback('/@?\{\{\s*\$?([a-zA-Z0-9_]+)\s*\}\}/', function (array $matches) use ($data): string {
            $key = strtolower($matches[1]);

            return isset($data[$key]) ? (string) $data[$key] : '';
        }, $content);
    }
}
