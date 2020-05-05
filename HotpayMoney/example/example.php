<?php
/**
 * Author: s.hulko
 * Date: 9/3/19
 * Time: 3:48 PM
 */

use HotpayMoney\ApiClient;
use \HotpayMoney\Exceptions\ApiException;

$secret_key = 'SECRET_KEY';
$ident = 'IDENT';

$api = new ApiClient($ident,$secret_key,'https://api.hotpay.money/v1');

try {
    $createBillResponse = $api->createBill("UAH",200,"UNIQUE_MERCHANT_ORDER","create example bill",["testing"=>true]);

    echo "Bill id: ".$createBillResponse->bill_id."<br> Bill url: ".$createBillResponse->url;

} catch (ApiException $e) {
    //TODO: do something in case of ApiErrorException
} catch (Exception $e) {
    //TODO: do something in case of common Exception
}





