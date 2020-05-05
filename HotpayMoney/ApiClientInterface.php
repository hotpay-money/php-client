<?php
/**
 * Author: s.hulko
 * Date: 9/2/19
 * Time: 12:36 PM
 */

namespace HotpayMoney;


use HotpayMoney\Exceptions\ApiException;
use HotpayMoney\Responses\BalanceResponse;
use HotpayMoney\Responses\BillResponse;
use HotpayMoney\Responses\CreateBillResponse;
use HotpayMoney\Responses\HistoryOperationsResponse;
use HotpayMoney\Responses\PayoutResponse;
use HotpayMoney\Responses\RatesResponse;
use HotpayMoney\Responses\StatisticResponse;
use Exception;

interface ApiClientInterface
{
    /**
     * @param string $ident Unique ident of your merchant.
     * @param string $secret_key Unique secret_key of your merchant.
     * @param string $api_host Connect url to the hotpay.money System according to the hotpay.money merchant documentation.
     * @return void
     */
    public function __construct($ident,$secret_key,$api_host);

    /**
     * Enable debug mode. If debug mode is enable
     * ApiClientException is contain more information about an error.
     *
     * @return void
     */
    public function enableDebugMode();

    /**
     * Disable debug mode. If debug mode is disable
     * ApiClientException is contain less information about an error.
     *
     *
     * @return void
     */
    public function disableDebugMode();

    /**
     * Creating new bill for merchant.
     * Method allow to create bill which user will pay for merchant account.
     *
     *
     * @param string $currency Currency of a creating bill. ISO 4217 format.
     * @param float $amount Amount of a creating bill
     * @param string $m_order Merchant order, maximum lenght is 255 symbols
     * @param string $description Details for user about bill
     * @param array $additional_params (optional) Additional params of a bill.
     * Keys list: payer_id,success_url,fail_url,status_url,m_name,expire_ttl,convert_to,extra,testing,p_method
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/post_create_bill
     * @return object|CreateBillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function createBill($currency,$amount,$m_order,$description,$additional_params=[]);

    /**
     * Find info about bill by bill id
     *
     *
     * @param integer $bill_id Bill ID for searching
     * @return object|BillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function findByBillId($bill_id);

    /**
     * Find info about bill by merchant`s order id
     *
     *
     * @param string $m_order Merchant order, maximum lenght is 255 symbols
     * @return object|BillResponse
     * @throws ApiException
     * @throws Exception
     */
    public function findByMOrder($m_order);

    /**
     * Send money from merchant to internal payment system account
     *
     *
     * @param string $m_order Merchant order, maximum lenght is 255 symbols
     * @param string $account Account of user registered in our system
     * @param string $currency Currency in ISO 4217
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $amount Operation amount
     * @param string $description Details for user about bill
     * @param array $additional_params (optional)
     * Keys list: to_curr,testing
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/post_payout
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payout($m_order,$account,$currency,$amount,$description,$additional_params=[]);

    /**
     * Send money to card
     *
     *
     * @param string $m_order Merchant order, maximum lenght is 255 symbols
     * @param string $currency Currency in ISO 4217
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $amount Operation amount
     * @param string $card_number Full card number for transaction
     * @param string $description Details for user about bill
     * @param array $additional_params (optional)
     * Keys list: to_curr,testing
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/post_payout_card
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payoutCard($m_order,$currency,$amount,$card_number,$description,$additional_params=[]);

    /**
     * Send money to cryptocurrency address
     *
     *
     * @param string $m_order Merchant order, maximum lenght is 255 symbols
     * @param string $currency Currency in ISO 4217
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $amount Operation amount
     * @param string $address Cryptocurrency address
     * @param string $description Details for user about bill
     * @param array $additional_params (optional)
     * Keys list: testing
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/post_payout_crypto
     * @return object|PayoutResponse
     * @throws ApiException
     * @throws Exception
     */
    public function payoutCrypto($m_order,$currency,$amount,$address,$description,$additional_params=[]);

    /**
     * Get current merchant balances
     *
     *
     * @return object|BalanceResponse
     * @throws ApiException
     * @throws Exception
     */
    public function balance();

    /**
     * Get current exchange rates.
     * NOTICE: One of "amount" or "receive_amount" are required, but not both at same time
     * For receiving common exchange rate set amount=1
     *
     *
     * @param string $from Currency in ISO 4217. Currency which must be converted
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param string $to Currency in ISO 4217. In this currency will be converted currency from 'from' field
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $amount default null Amount which need to exchange (send funds in currency from 'from' field)
     * @param float $receive_amount default null Amount which need to receive, (how much receive funds in currency from 'to' field)
     * @return object|RatesResponse
     * @throws ApiException
     * @throws Exception
     */
    public function rates($from,$to,$amount=null,$receive_amount=null);

    /**
     * Get current exchange rates by amount.
     *
     *
     * @param string $from Currency in ISO 4217. Currency which must be converted
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param string $to Currency in ISO 4217. In this currency will be converted currency from 'from' field
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $amount Amount which need to exchange (send funds in currency from 'from' field)
     * @return object|RatesResponse
     * @throws ApiException
     * @throws Exception
     */
    public function ratesByAmount($from,$to,$amount);

    /**
     * Get current exchange rates by receive amount.
     *
     *
     * @param string $from Currency in ISO 4217. Currency which must be converted
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param string $to Currency in ISO 4217. In this currency will be converted currency from 'from' field
     * Available values : UAH, RUB, EUR, USD, BTC, ETH, DASH, LTC
     * @param float $receive_amount default null Amount which need to receive, (how much receive funds in currency from 'to' field)
     * @return object|RatesResponse
     * @throws ApiException
     * @throws Exception
     */
    public function ratesByReceiveAmount($from,$to,$receive_amount);

    /**
     * Total statistic of merchant operation
     *
     *
     * @param array $additional_params (optional)
     * Keys list: currency,begin,end,operation_type,show_testing
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/get_stats
     * @return object|StatisticResponse
     * @throws ApiException
     * @throws Exception
     */
    public function stats($additional_params=[]);

    /**
     * All transaction history in merchant account
     *
     *
     * @param array $additional_params (optional)
     * Keys list: begin,end,status,payment_method,operation_type,limit,offset,show_testing
     * @see More details on the @link https://app.swaggerhub.com/apis-docs/hotpay.money/Merchant/1.0#/merchantapi/get_history
     * @return object|HistoryOperationsResponse
     * @throws ApiException
     * @throws Exception
     */
    public function history($additional_params=[]);
}