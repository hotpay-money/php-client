<?php
/**
 * Author: s.hulko
 * Date: 8/30/19
 * Time: 11:41 AM
 */

namespace HotpayMoney\Responses;


class RatesResponse
{
    /** @var string */
    public $withdraw_amount;
    /** @var string */
    public $withdraw_curr;
    /** @var string */
    public $receive_amount;
    /** @var string */
    public $receive_curr;
    /** @var string */
    public $exchange_rate;
}