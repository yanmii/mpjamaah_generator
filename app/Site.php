<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'app_name', 'slug', 'app_id', 'bundle_id', 'logo', 'ic_file', 'url_prod', 'url_wa', 'ts_license_key'
    ];
}
