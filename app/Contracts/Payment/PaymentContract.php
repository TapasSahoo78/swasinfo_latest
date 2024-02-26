<?php

namespace App\Contracts\Payment;

/**
 * Interface AdsContract
 * @package App\Contracts
 */
interface PaymentContract
{
    public function createOrder(array $attributes);
}
