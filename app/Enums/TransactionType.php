<?php

namespace App\Enums;

use InvalidArgumentException;

class TransactionType
{
    const TAHSEEL = 1;
    const DEPOSIT = 2;
    const HADBACK = 3;

    private $type;

    private function __construct($type)
    {
        $this->type = $type;
    }

    public static function DEPOSIT(): self
    {
        return new self(self::DEPOSIT);
    }

    public static function TAHSEEL(): self
    {
        return new self(self::TAHSEEL);
    }

    public static function HADBACK(): self
    {
        return new self(self::HADBACK);
    }

    public function getDescription(): string
    {
        switch ($this->type) {
            case self::DEPOSIT:
                return 'A deposit transaction';
            case self::TAHSEEL:
                return 'A TAHSEEL transaction';
            case self::HADBACK:
                return 'A hadback transaction';
            default:
                throw new InvalidArgumentException("Invalid transaction type");
        }
    }
    public function nameInAr(): string
    {
        switch ($this->type) {
            case self::DEPOSIT:
                return 'مرتجع';
            case self::TAHSEEL:
                return 'تحصيل';
            case self::HADBACK:
                return 'مقدم';
            default:
                throw new InvalidArgumentException("نوع غير موجود");
        }
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
