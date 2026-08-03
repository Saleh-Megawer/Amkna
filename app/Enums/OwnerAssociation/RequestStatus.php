<?php
namespace App\Enums\OwnerAssociation;

use App\Enums\Traits\HasEnums;

enum RequestStatus: string {
    use HasEnums;

    case PENDING      = 'pending';
    case UNDER_REVIEW = 'under_review';
    case IN_PROGRESS  = 'in_progress';
    case COMPLETED    = 'completed';
    case CLOSED       = 'closed';
    case REJECTED     = 'rejected';
    case CANCELLED    = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING      => __('statuses.pending'),
            self::UNDER_REVIEW => __('statuses.under_review'),
            self::IN_PROGRESS  => __('statuses.in_progress'),
            self::COMPLETED    => __('statuses.completed'),
            self::CLOSED       => __('statuses.closed'),
            self::REJECTED     => __('statuses.rejected'),
            self::CANCELLED    => __('statuses.cancelled'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING      => 'bg-secondary text-white',
            self::UNDER_REVIEW => 'bg-info text-white',
            self::IN_PROGRESS  => 'bg-primary text-white',
            self::COMPLETED    => 'bg-success text-white',
            self::CLOSED       => 'bg-dark text-white',
            self::REJECTED     => 'bg-danger text-white',
            self::CANCELLED    => 'bg-warning text-white',
        };
    }
}
