<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getSetting($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    public static function setSetting($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
