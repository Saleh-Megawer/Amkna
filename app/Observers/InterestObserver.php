<?php
namespace App\Observers;

use App\Models\Interest;
use App\Services\LeadAssignmentService;

class InterestObserver
{
    protected $assignmentService;

    public function __construct(LeadAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    /**
     * Handle the Interest "created" event.
     */
    public function created(Interest $interest): void
    {
        $this->assignmentService->autoAssign($interest);
    }

    /**
     * Handle the Interest "updated" event.
     */
    public function updated(Interest $interest): void
    {
        //
    }

    /**
     * Handle the Interest "deleted" event.
     */
    public function deleted(Interest $interest): void
    {
        //
    }

    /**
     * Handle the Interest "restored" event.
     */
    public function restored(Interest $interest): void
    {
        //
    }

    /**
     * Handle the Interest "force deleted" event.
     */
    public function forceDeleted(Interest $interest): void
    {
        //
    }
}
