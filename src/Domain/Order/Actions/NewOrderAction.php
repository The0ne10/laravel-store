<?php

namespace Domain\Order\Actions;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Order\DTOs\OrderFormDTO;
use Domain\Order\Models\Order;

final class NewOrderAction
{
    public function __invoke(OrderFormDTO $dto): Order
    {
        $registerAction = app(RegisterNewUserAction::class);

        $customer = $dto->customer;

    }
}
