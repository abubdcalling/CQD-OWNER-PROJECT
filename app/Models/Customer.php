<?php

namespace App\Models;

use DB;
use Http;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'country',
        'city',
        'region',
        'zip_code',
        'street',
        'lat',
        'lng',
        'package_id',
        'group_id',
        'address'
    ];

    public function package(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo(Package::class);
    }

    public function getAvatarAttribute($value): string | null
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Check if the request is an API request
        if (request()->is('api/*') && !empty($value)) {
            // Return the full URL for API requests
            return url($value);
        }
        // Return only the path for web requests
        return $value;
    }



    // Find users within a given radius (in km)
    public static function findUsersWithinRadius($lat, $lon, $zip_code, $package_id, $radius = 10)
    {
        return self::query()
            ->where('zip_code', $zip_code)
            ->where('package_id', $package_id)
            ->with(['group.members'])
            ->whereHas('group', function ($query) {
                $query->whereRaw('total_members > (SELECT COUNT(*) FROM customers WHERE groups.id = customers.group_id)');
            })->selectRaw(
            "*, (
                6371 * acos(
                    cos(radians(?)) * cos(radians(lat)) *
                    cos(radians(lng) - radians(?)) +
                    sin(radians(?)) * sin(radians(lat))
                )
            ) AS distance",
            [$lat, $lon, $lat]
        )
        ->having('distance', '<=', $radius)
        ->orderBy('distance');
    }



    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class);
    }


    // Save latitude and longitude from zip code
    function getZipCode($latitude, $longitude)
    {
        $apiKey = 'AIzaSyBP_63liD8mOmG2MqruuRgwryln5d9aSNY';
        $url = "https://maps.googleapis.com/maps/api/geocode/json";

        // Send a GET request
        $response = Http::get($url, [
            'latlng' => "{$latitude},{$longitude}",
            'key' => $apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (!empty($data['results'])) {
                foreach ($data['results'][0]['address_components'] as $component) {
                    if (in_array('postal_code', $component['types'])) {
                        return $component['long_name'];
                    }
                }
            }
        }

        return null;
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BusinessDetail::class,'customer_id');
    }
}


