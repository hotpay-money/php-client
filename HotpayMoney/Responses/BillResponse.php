<?php
/**
 * Author: s.hulko
 * Date: 8/30/19
 * Time: 11:09 AM
 */

namespace HotpayMoney\Responses;


class BillResponse
{
    /** @var string */
    public $amount;
    /** @var integer */
    public $created_at;
    /** @var string */
    public $currency;
    /** @var string */
    public $description;
    /** @var integer */
    public $expire_at;
    /** @var integer */
    public $id;
    /** @var string */
    public $status;
    /** @var string */
    public $m_order;
    /** @var boolean */
    public $testing;
}