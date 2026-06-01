<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = ['url', 'ip', 'referrer', 'device', 'created_at'];

    protected $casts = ['created_at' => 'datetime'];

    public static function detectDevice(string $ua): string
    {
        $ua = strtolower($ua);
        if (preg_match('/tablet|ipad|playbook|silk/', $ua)) return 'tablet';
        if (preg_match('/mobile|android|iphone|ipod|blackberry|windows phone/', $ua)) return 'mobile';
        return 'desktop';
    }
}
