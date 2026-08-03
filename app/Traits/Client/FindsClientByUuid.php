<?php
namespace App\Traits\Client;

use App\Models\Dashboard\Crm\Client\Client;

trait FindsClientByUuid
{
    /**
     * Get property ID from request UUID.
     */
    protected function getPropertyId($uuid = null)
    {
        $uuid ??= request('client_uuid');

        return Client::where('uuid', $uuid)
            ->value('id');
    }

}
