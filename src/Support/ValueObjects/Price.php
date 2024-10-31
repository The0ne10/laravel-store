<?php

namespace Support\ValueObjects;

use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100,
    )
    {
        if($this->value < 0) {
            throw new \InvalidArgumentException('Value must be greater than 0');
        }

        if(!isset($this->currencies[$this->currency])) {
            throw new \InvalidArgumentException('Invalid currency');
        }
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function raw(): int
    {
        return $this->value;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->value(), 0, ',', ' ')
            . $this->symbol();
    }
}
