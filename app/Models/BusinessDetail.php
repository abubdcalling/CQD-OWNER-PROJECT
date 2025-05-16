<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    protected $fillable = [
        'company_name',
        'type',
        'industry',
        'number_of_employees',
        'website',
        'address',
        'business_description',
        'service_type',
        'service_description',
        'is_share',
        'customer_id'
    ];


}
