<?php
namespace App\Traits\Property;

use App\Models\Property\Property;

trait FindsPropertyByUuid
{
    /**
     * Get property ID from request UUID.
     */
    protected function getPropertyId($uuid = null)
    {
        $uuid ??= request('property_uuid');

        return Property::where('uuid', $uuid)
            ->value('id');
    }

}
