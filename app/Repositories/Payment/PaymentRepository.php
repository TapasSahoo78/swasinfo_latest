<?php

namespace App\Repositories\Payment;




use App\Models\Order;
use Stripe\StripeClient;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\OrderAddress;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Contracts\Payment\PaymentContract;

/**
 * Class PaymentRepository
 *
 * @package \App\Repositories
 */
class PaymentRepository extends BaseRepository implements PaymentContract
{
    protected $model;

    protected $orderAddressModel;

    protected $odrederDetailsModel;

    protected $transactionModel;

    protected $stripePayment;

    public function __construct(Order $model,OrderAddress $orderAddressModel,OrderDetail $odrederDetailsModel,Transaction $transactionModel)
    {
        parent::__construct($model);
        $this->orderAddressModel = $orderAddressModel;
        $this->odrederDetailsModel = $odrederDetailsModel;
        $this->transactionModel = $transactionModel;
        // $this->stripePayment = new StripeClient(config('services.stripe.secret'));
    }

    public function createOrder(array $attributes){
        $isOrderCreated= $this->create([
            'user_id' => auth()->user()->id,
            'delivery_status' =>false,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
        if($isOrderCreated){
            $carts= auth()->user()->carts;
            $price= 0;
            foreach ($carts as $cart) {
                $price = $price+$cart->product->discounted_price;
                $isOrderDetailsCreated=$isOrderCreated->details()->create([
                    'product_id'=> $cart->product_id,
                    'additional_details'=> $cart->product,
                    'shipping_cost'=> 0,
                    'vendor_id'=> $cart->product->vendor_id,
                    'quantity'=> $cart->quantity,
                ]);
            }
            $isOrderAddressCreated= $isOrderCreated->orderAddress()->create([
                'full_address' => $attributes['order']['full_address'],
                'zip_code' => $attributes['order']['zip_code']
            ]);
            $isTransactionCreated= $isOrderCreated->orderTransaction()->create([
                'user_id'=> auth()->user()->id,
                'ammount'=> $price,
                'transactionable_type'=>get_class($isOrderCreated),
                'transactionable_id'=>$isOrderCreated->id,
                'currency'=>'usd',
                'payment_gateway'=>'bypassed',
                'payment_gateway_id'=>rand(6,10).'-'.now(),
                'payment_gateway_uuid'=>Str::uuid(),
                'status'=>true,
            ]);
            auth()->user()->carts()->delete();
            session()->put('order_id', $isOrderCreated->order_no);
        }
        return $isOrderCreated;
    }
}
