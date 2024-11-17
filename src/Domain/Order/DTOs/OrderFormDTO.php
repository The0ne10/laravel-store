<?php

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

class OrderFormDTO
{
    use Makeable;

    public function __construct(
        public array $customer,
    )
    {}

    public static function fromRequest(Request $request): self
    {
        return self::make(...$request->only(['customer']));
    }
}
