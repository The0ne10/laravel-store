<?php

namespace Domain\Order\States;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'panding';
    }

    public function humanValue(): string
    {
        return 'В обработке';
    }
}
