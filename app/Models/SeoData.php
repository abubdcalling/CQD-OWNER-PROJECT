<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoData extends Model
{
    protected $fillable = ['page_type', 'page_id', 'meta_title', 'meta_description', 'meta_keywords'];
}
