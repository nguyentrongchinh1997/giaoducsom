<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function(){
    $response = \VNPay::purchase([
        'vnp_TxnRef' => time(),
        'vnp_OrderType' => 100000,
        'vnp_OrderInfo' => time(),
        'vnp_IpAddr' => '127.0.0.1',
        'vnp_Amount' => 1000000,
        'vnp_ReturnUrl' => 'http://127.0.0.1:8000/result',
    ])->send();
    
    if ($response->isRedirect()) {
        $redirectUrl = $response->getRedirectUrl();
        return redirect($redirectUrl);
        
        // TODO: chuyển khách sang trang VNPay để thanh toán
    }
});

Route::get('result', function(){
    $response = \VNPay::completePurchase()->send();

    if ($response->isSuccessful()) {
        // TODO: xử lý kết quả và hiển thị.
        print $response->vnp_Amount;
        print $response->vnp_TxnRef;
        dd($response->getData());
        var_dump($response->getData()); // toàn bộ data do VNPay gửi sang.
        
    } else {

        print $response->getMessage();
    }
});