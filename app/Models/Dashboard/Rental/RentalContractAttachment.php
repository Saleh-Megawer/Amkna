<?php

namespace App\Models\Dashboard\Rental;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentalContractAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationships

    public function rentalContract()
    {
        return $this->belongsTo(RentalContract::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }
}
