<?php

namespace App\Services\Payment;

use Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Payment\PaymentContract;

class PaymentService{

    /**
     * @var PaymentContract
     */
    protected $paymentRepository;

    public function __construct(PaymentContract $paymentRepository){
        $this->paymentRepository = $paymentRepository;
    }


    public function createOrder(array $attributes){
        return $this->paymentRepository->createOrder($attributes);
    }


}
