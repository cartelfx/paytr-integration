<?php

use Mews\Paytr\Facades\Paytr;

$config = include('config/paytr.php');

$payment = Paytr::make([
    'merchant_id' => $config['merchant_id'], 
    'user_ip' => $_SERVER['REMOTE_ADDR'],
    'merchant_oid' => uniqid(), // sipariş numarası
    'email' => 'cartellive@info.com', // mail
    'payment_amount' => 1000, // kuruş bazında fiyat
    'user_basket' => base64_encode(json_encode([["Mouse", "1", "1000"]])), // sepet içeriği
    'debug_on' => $config['debug_on'], 
    'no_installment' => 0, // taksit pasif = 0 aktif = 1
    'max_installment' => 0, // maksimum taksit sayı pasif = 0
    'user_name' => 'Münür Akdemir', // kullanıcı adı ve soyadı
    'user_address' => 'Adres bilgisi', // Kullanıcı adresi
    'user_phone' => '05543266754', // Kullanıcı telefon numarası
    'merchant_ok_url' => $config['ok_url'],
    'merchant_fail_url' => $config['fail_url'],
    'timeout_limit' => 30, // İşlem zaman aşımı süresi
    'currency' => $config['currency'], // İşlem para birimi
]);

if ($payment['status'] == 'success') {
    // Ödeme başarılı, kullanıcının yönlendirileceği URL'yi alalım
    header('Location: https://www.paytr.com/odeme/guvenli/' . $payment['token']);
    exit;
} else {
    // Ödeme başarısız, hata sebebini gösterebilirsiniz
    echo 'Hata: ' . $payment['reason'];
}
