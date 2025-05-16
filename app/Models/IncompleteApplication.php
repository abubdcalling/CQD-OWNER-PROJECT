<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncompleteApplication extends Model
{
    protected $fillable = ['company_name', 'email', 'phone','reminder_count','package_id'];

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
