<?php
/**
 * Author: s.hulko
 * Date: 8/29/19
 * Time: 1:25 PM
 */

namespace HotpayMoney\Exceptions;


use Error;

class ApiException extends \Exception
{
    protected $body;
    private $innerMsg;

    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($this->displayMessage($message), $code, $previous);
    }

    /**
     * @param mixed $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param $msg
     * @return
     */
    private function displayMessage($msg) {
        return $msg;
    }

    /**
     * @param $msg
     * @return void
     */
    public function innerMsgAdd($msg) {
        $this->innerMsg[] = $msg;
    }

    /**
     * @return Error
     */
    public function getErrorResponse() {
        $response = new Error($this->getMessage(), $this->innerMsg);
        return $response;
    }

}