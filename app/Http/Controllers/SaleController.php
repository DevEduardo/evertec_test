<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\NotificationRegister;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Customer;

class SaleController extends Controller
{
    private $modelCustomer;
    protected $placetopay;

    public function __construct(Customer $modelCustomer)
    {
        $this->modelCustomer = $modelCustomer;

        $this->placetopay = new PlacetoPay([
            'login' => env('PLACETOPAY_LOGIN'),
            'tranKey' => env('PLACETOPAY_TRANKEY'),
            'url' => env('PLACETOPAY_URL'),
        ]);
    }

    public function orders()
    {
        $orders = $this->modelCustomer->filterEmail(Auth::user()->email);
        return response()->json(['orders' => $orders, 'email' => Auth::user()->email]);
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
        $codeSale = 'YS-'. time();

        $dataToPLaceTopay = [
            'buyer' => [
                "name" => $request->customer_name,
                "email" => $request->customer_email,
                "mobile" => $request->customer_mobile
            ],
            'payment' => [
                'reference' => $codeSale,
                'description' => 'iPhone 12 Pro',
                'amount' => [
                    'currency' => 'USD',
                    'total' => env('PRICE_PRODUCT') * $request->quantity,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://127.0.0.1/response/' . $codeSale,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        $response = $this->placetopay->request($dataToPLaceTopay);
        
        if ($response->isSuccessful()) {

            $data = $this->modelCustomer->create($request, $response->requestId, $codeSale);

            $this->userRegister($request);
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
        $sale = $this->modelCustomer->findBySaleCode($reference);

        $response = $this->placetopay->query($sale->payment_id);

        if ($response->isSuccessful() ) {
            if ($response->status()->isApproved()) {
                $this->modelCustomer->changeStatusSale($response->status()->status(), $sale->id);
                
                return redirect()->to('/dashboard');
            }
            $this->modelCustomer->changeStatusSale($response->status()->status(), $sale->id);
            return redirect()->to('/');
        } else {
            return redirect()->to('/');
        }
    }

    private function userRegister($data)
    {
        $pass = Str::random(10);

        if (!User::where('email', $data->customer_email)->first()) {
            $user = User::create([
                'name' => $data->customer_name,
                'email' => $data->customer_email,
                'password' => Hash::make($pass),
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
            Mail::to($user)->send(new NotificationRegister(['email' => $user->email, 'pass' => $pass]));
        }
       
    }
}
