<?php
/**
 * Author: s.hulko
 * Date: 8/30/19
 * Time: 12:34 PM
 */

namespace HotpayMoney\Responses;


class OperationResponse
{
    /** @var string */
    public $amount;
    /** @var integer */
    public $bill_id;
    /** @var integer */
    public $created_at;
    /** @var string */
    public $currency;
    /** @var integer */
    public $order_id;
    /** @var RecipientResponse */
    public $recipient;
    /** @var SenderResponse */
    public $sender;
    /** @var string */
    public $status;
    /** @var boolean */
    public $testing;

}