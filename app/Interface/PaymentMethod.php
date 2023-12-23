<?php

namespace App\Interface;

class PaymentMethod
{
    static function getAllPaymentMethod()
    {
        return [
            PaymentMethodEnum::Cash,
            PaymentMethodEnum::Debit,
            PaymentMethodEnum::QRIS,
            PaymentMethodEnum::Malltronik
        ];
    }
}
enum PaymentMethodEnum
{
    case Cash;
    case Debit;
    case QRIS;
    case Malltronik;
}
