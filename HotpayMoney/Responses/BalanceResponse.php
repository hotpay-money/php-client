<?php
/**
 * Author: s.hulko
 * Date: 8/30/19
 * Time: 11:34 AM
 */

namespace HotpayMoney\Responses;


class BalanceResponse
{
    /** @var integer */
    public $client_id;
    /** @var string */
    public $balance;
    /** @var string */
    public $currency;
    /** @var boolean */
    public $active;
    /** @var integer */
    public $create_date;
    /** @var integer */
    public $update_date;
}