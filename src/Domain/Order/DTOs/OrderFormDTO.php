<?php

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class OrderFormDTO
{
    use Makeable;

    public function __construct(
        public ?array $customer = null,
        public ?bool $create_account = false,
        public ?string $password = null,
        public ?int $delivery_type_id = null,
        public ?int $payment_method_id = null,
    )
    {}

    public static function fromRequest(Request $request): self
    {
        return self::make(...$request->only([
            'customer',
            'create_account',
            'password',
            'delivery_type_id',
            'payment_method_id'
        ]));
    }
}
