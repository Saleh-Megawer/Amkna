<?php
namespace App\Traits\Client;

use App\Helpers\Response;
use Illuminate\Database\Eloquent\Model;

trait EnsuresClientOwnership
{
    /**
     * Ensure that a child model belongs to the given client.
     *
     * @param  \App\Models\Dashboard\Crm\Client\Client  $client
     * @param  \Illuminate\Database\Eloquent\Model      $childModel
     * @param  string                                   $foreignKey
     *
     * @return void
     */
    public function ensureClientOwnership($client, Model $childModel, bool $returnResponse = true)
    {
        if ($childModel->client_id !== $client->id) {

            if ($returnResponse) {
                return Response::error('This item does not belong to the client', ['style' => 'toastr']);
            }

            abort(404);
        }

        return true;
    }

}
