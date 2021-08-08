<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'status',
        'payment_id',
        'quantity',
        'amount'
    ];

    public function create($sale, $payment_id, $code)
    {
        try {
            \DB::beginTransaction();
            $customer = new self();
            $customer->sale_code = $code;
            $customer->customer_name = $sale->customer_name;
            $customer->customer_email = $sale->customer_email;
            $customer->customer_mobile = $sale->customer_mobile;
            $customer->payment_id = $payment_id;
            $customer->quantity = $sale->quantity;
            $customer->amount = 2000 * $sale->quantity;
            $customer->save();
            \DB::commit();
            return $customer;

        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }
        
    }
}
