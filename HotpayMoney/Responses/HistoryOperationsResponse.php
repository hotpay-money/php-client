<?php
/**
 * Author: s.hulko
 * Date: 8/30/19
 * Time: 12:28 PM
 */

namespace HotpayMoney\Responses;


class HistoryOperationsResponse
{
    /** @var OperationResponse[] */
    public $operations;
    /** @var integer */
    public $total;
    /** @var integer */
    public $limit;
    /** @var integer */
    public $offset;

}