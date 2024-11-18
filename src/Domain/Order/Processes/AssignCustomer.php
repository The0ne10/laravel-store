<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\OrderFormDTO;
use Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessContract
{

    public function __construct(protected OrderFormDTO $dto)
    {}

    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->dto->customer);

        return $next($order);
    }
}
