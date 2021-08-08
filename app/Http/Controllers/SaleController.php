<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Order;

class SaleController extends Controller
{
    private $modelCustomer;

    public function __construct(Customer $modelCustomer)
    {
        $this->modelCustomer = $modelCustomer;
    }

    public function detail(Request $request)
    {
        return Inertia::render('Detail', [
            'quantityProps' => $request->quantity,
            'auth' => Auth::user()
        ]);
    }

    public function payment(Request $request)
    {
        //crear variables de entorno
        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://dev.placetopay.com/redirection',
            'rest' => [
                'timeout' => 45,
                'connect_timeout' => 30,
            ]
        ]);
        
        $codeSale = 'YS-'. time();

        $dataToPLaceTopay = [
            'buyer' => [
                "name" => $request->customer_name,
                "email" => $request->customer_email,
                "mobile" => $request->customer_mobile
            ],
            'payment' => [
                'reference' => $codeSale,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://127.0.0.1/response/' . $codeSale,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

            $response = $placetopay->request($dataToPLaceTopay);
            
            if ($response->isSuccessful()) {

                $data = $this->modelCustomer->create($request, $response->requestId, $codeSale);
                
                return Inertia::render('Detail', [
                    'url' => $response->processUrl,
                    'auth' => Auth::user()
                ]);
            } else {
                dd($response);
            }
        
    }

    public function response($reference)
    {
        //crear variables de entorno
        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://dev.placetopay.com/redirection',
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);

        $response = $placetopay->query();

        if ($response->isSuccessful()) {
            if ($response->status()->isApproved()) {
                return response()->json($response);
            }
        } else {
            print_r($response->status()->message() . "\n");
        }
    }
}
