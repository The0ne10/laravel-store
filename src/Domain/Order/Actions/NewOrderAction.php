<?php

namespace Domain\Order\Actions;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserActionContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Order\DTOs\OrderFormDTO;
use Domain\Order\Models\Order;

final class NewOrderAction
{
    public function __invoke(OrderFormDTO $dto): Order
    {
        $registerAction = app(RegisterNewUserActionContract::class);

        $customer = $dto->customer;

        if ($dto->create_account) {
            $user = $registerAction(NewUserDTO::make(
               name: $customer['first_name'] . ' ' . $customer['last_name'],
               email: $customer['email'],
               password: $dto->password,
           ));
        }

        return Order::query()->create([
            'payment_method_id' => $dto->payment_method_id,
            'delivery_type_id' => $dto->delivery_type_id,
        ]);
    }
}
