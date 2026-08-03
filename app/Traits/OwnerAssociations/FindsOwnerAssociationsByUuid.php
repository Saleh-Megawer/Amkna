<?php
namespace App\Traits\OwnerAssociations;
use App\Models\OwnerAssociation\OwnerAssociation;

trait FindsOwnerAssociationsByUuid
{
    /**
     * Get property ID from request UUID.
     */
    protected function getOwnerAssociationsId($uuid = null)
    {
        $uuid ??= request('owner_association_id');

        return OwnerAssociation::where('uuid', $uuid)
            ->value('id');
    }

}
