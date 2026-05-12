<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'favicon_path',
    ];

    /**
     * @return array{site_name: string, logo_url: ?string, favicon_url: ?string}
     */
    public static function branding(): array
    {
        $defaults = [
            'site_name' => (string) config('app.name', 'Laravel'),
            'logo_url' => null,
            'favicon_url' => null,
        ];

        try {
            if (! Schema::hasTable('site_settings')) {
                return $defaults;
            }
        } catch (\Throwable) {
            return $defaults;
        }

        $row = static::query()->first();
        if ($row === null) {
            return $defaults;
        }

        $siteName = trim((string) $row->site_name) !== '' ? $row->site_name : $defaults['site_name'];

        $logoUrl = $row->logo_path ? asset('storage/'.$row->logo_path) : null;
        $faviconUrl = $row->favicon_path ? asset('storage/'.$row->favicon_path) : null;

        return [
            'site_name' => $siteName,
            'logo_url' => $logoUrl,
            'favicon_url' => $faviconUrl,
        ];
    }
}
