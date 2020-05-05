# Merchant's Api Client
Simple desigion to make all merchant's request to the HotPay API.
---
Link to the official documentation: https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0
---
The library currently provides the following operations according to the hotpay.money official doccumentation:
 - /create_bill
 - /find/by_bill_id
 - /find/by_m_order
 - /payout
 - /payout_card
 - /payout_crypto
 - /balance
 - /rates
 - /stats
 - /history
 
## Requirements

PHP 5.5 and later

---

# Usage

Before you can create a new Api client class instance you have to prepare and save your unique merchant ident and secret key in your merchant account settings.
Link for register like a partner - http://hotpay.money/ru/partner/registration. Then create your merchant there.

And download api client library

```
composer require hotpay_money/api_client 
```
Create Api client and add your ident and secret key there.

```
$secret_key = 'SECRET_KEY';
$ident = 'IDENT';
$api = new ApiClient($ident,$secret_key,'https://api.hotpay.money/v1');
```

Via ApiClient object you can send requests to the HotPay Api.

```
try {
    $createBillResponse = $api->createBill("UAH",200,"UNIQUE_MERCHANT_ORDER","create example bill",["testing"=>true]);

} catch (ApiException $e) {

} catch (Exception $e) {

}
```


