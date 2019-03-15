<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Places\{ Country, Province };
use App\Http\Resources\Location\Province as ProvinceResource;
use App\Http\Resources\Location\City as CityResource;

class LocationController extends Controller
{
    /**
     * Get the list of all the provinces in the specific country
     *
     * @param Country $country
     * @return void
     */
    public function provinces(Country $country)
    {
        return ProvinceResource::collection( $country->provinces );
    }

    /**
     * Get the list of all the cities in the specific province
     *
     * @param Province $province
     * @return void
     */
    public function cities(Province $province)
    {
        return CityResource::collection( $province->cities );
    }
}
