<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
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
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);

        $reference = 'eduardo';
        $request = [
            'buyer' => [
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->phone
            ],
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://127.0.0.1/response/' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $placetopay->request($request);
        if ($response->isSuccessful()) {
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
            // In order to use the functions please refer to the Dnetix\Redirection\Message\RedirectInformation class

            if ($response->status()->isApproved()) {
                return response()->json($response);
            }
        } else {
            // There was some error with the connection so check the message
            print_r($response->status()->message() . "\n");
        }
    }
}
