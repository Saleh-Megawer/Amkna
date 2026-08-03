<?php
namespace App\Services;

use App\Models\Interest;
use App\Models\Dashboard\Admin\Admin;

class LeadAssignmentService
{
    /**
     * Get the best available sales admin with the lowest lead count
     */
    public function getBestAvailableSalesAdmin()
    {
        return Admin::where('type', 'sales')
            ->where('is_available', 1)
            ->where('status', '1')
            ->withCount(['assignedInterests' => function ($query) {
                // Count only active/open interests (customize as needed)
                $query->whereIn('status', ['new', 'assigned', 'contacted']);
            }])
            ->orderBy('assigned_interests_count', 'asc')
            ->orderBy('id', 'asc') // Tie-breaker
            ->first();
    }

    /**
     * Assign an interest to a sales admin
     */
    public function assignInterest(Interest $interest, Admin $admin)
    {
        $interest->update([
            'assigned_to' => $admin->id,
            'assigned_at' => now(),
            'status'      => 'assigned', // Optional: change status
        ]);
    }

    /**
     * Auto-assign an interest to the best available sales admin
     */
    public function autoAssign(Interest $interest)
    {
        // Skip if already assigned
        if ($interest->assigned_to) {
            return;
        }

        $admin = $this->getBestAvailableSalesAdmin();

        if ($admin) {
            $this->assignInterest($interest, $admin);
        }
    }
}
