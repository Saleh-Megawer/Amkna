<?php
namespace App\Services\Rental;

use App\Models\Dashboard\Rental\RentalContract;
use App\Models\Dashboard\Rental\RentalPaymentSchedule;
use Carbon\Carbon;

class PaymentScheduleService
{
    public function generateSchedules(RentalContract $contract): void
    {
        $startDate = Carbon::parse($contract->start_date);
        $endDate   = Carbon::parse($contract->end_date);
        $frequency = $contract->payment_frequency->value;
        $amount    = $contract->expected_payment_amount;

        $paymentNumber = 1;
        $currentDate   = clone $startDate;

        // إضافة الفترة الأولى بناءً على التردد
        $currentDate = $this->addPeriod($currentDate, $frequency);

        while ($currentDate <= $endDate) {
            RentalPaymentSchedule::create([
                'rental_contract_id' => $contract->id,
                'payment_number'     => $paymentNumber,
                'due_date'           => $currentDate->toDateString(),
                'amount'             => $amount,
                'status'             => 'pending',
            ]);

            $paymentNumber++;
            $currentDate = $this->addPeriod($currentDate, $frequency);
        }
    }

    private function addPeriod(Carbon $date, string $frequency): Carbon
    {
        return match ($frequency) {
            'daily'   => $date->addDay(),
            'monthly' => $date->addMonth(),
            'yearly'  => $date->addYear(),
            default   => $date->addMonth(),
        };
    }
}
