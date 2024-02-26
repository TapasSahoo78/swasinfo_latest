<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Payment\PaymentService;

class PaymentController extends BaseController
{
    protected $userService;
    protected $paymentService;
    public function __construct(
        UserService $userService,
        PaymentService $paymentService
    ) {
        $this->userService = $userService;
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {
        $this->setPageTitle('Customer Checkout');
        $user = auth()->user()->addressBook;
        $default_address = $user->where('is_default', true)->first();
        $carts= auth()->user()->carts;
        if($request->post()){
            session()->put('order',$request->except('_token'));
            return $this->responseRedirect('payment.details','Address added successfully','success');
        }
        return view('customer.payment.checkout',compact('carts','default_address'));
    }
    public function paymentDetails(Request $request)
    {
        $this->setPageTitle('Payment Details');
        if($request->post()){
            $order= session()->get('order',[]);
            $request->merge(['order'=> $order]);
            DB::beginTransaction();
            try{
                $isOrderCompleted = $this->paymentService->createOrder($request->except('_token'));
                if($isOrderCompleted){
                    DB::commit();
                    return $this->responseRedirect('payment.success','Order placed successfully','success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went Wrong','error',true);
            }


        }
        return view('customer.payment.card');
    }
    public function paymentSucces(Request $request)
    {
        $this->setPageTitle('Payment Successfull');
        return view('customer.payment.success');
    }

}
