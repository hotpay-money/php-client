<?php
/**
 * Author: s.hulko
 * Date: 8/29/19
 * Time: 1:13 PM
 */

namespace HotpayMoney;


class QueryBuilder
{
    /** @var string */
    private $baseUrl;
    /** @var string */
    private $apiServerUrl;
    /** @var string GET | POST*/
    private $requestType;
    /** @var array*/
    private $params = [];
    /** @var array*/
    private $headers;
    /** @var string */
    private $userGeo;
    /** @var string */
    private $ident;
    /** @var string */
    private $secret_key;

    /**
     * @param string $baseUrl
     * @param string $apiURL string address connect to
     * @param string $ident
     * @param string $secret_key
     * @param string $requestType GET | POST
     */
    function __construct($baseUrl, $apiURL, $ident, $secret_key, $requestType = "GET") {
        $this->requestType = $requestType;
        $this->baseUrl = $baseUrl;
        $this->apiServerUrl = $apiURL;
        $this->userGeo = (isset($_SERVER['GEOIP_COUNTRY_CODE']) && !empty($_SERVER['GEOIP_COUNTRY_CODE'])) ? $_SERVER['GEOIP_COUNTRY_CODE'] : "ww";
        $this->ident = $ident;
        $this->secret_key = $secret_key;
    }

    /**
     * @param string $name
     * @param $value
     * @param bool $mustBeValid
     * @param string $type
     * @throws \Exception
     */
    public function addParam($name, $value, $mustBeValid=false, $type = 'string') {
        if ($mustBeValid && !$value && $type =='string') {
            throw new \Exception("Parameter \"$name\" must be valid. Value=\"$value\" is not valid");
        }
        if ($mustBeValid && !is_numeric($value) && $type == 'numeric') {
            throw new \Exception("Parameter \"$name\" must be valid. Value=\"$value\" is not valid");
        }
        $this->params[$name] = $value;
    }

    /**
     * @param bool $fileSend
     * @return array
     */
    public function getRequestHeaders($fileSend = false) {
        $this->headers["Expect"] = '';
        $this->headers["X-User-Geo"] = $this->userGeo;
        $this->headers["X-User-Real-Ip"] = isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"UNDEFINED";
        if ($fileSend) {
            $this->headers["Content-Type"] = "multipart/form-data";
        } else {
            $this->headers["Content-Type"] = "application/x-www-form-urlencoded";
        }


        $headersRawArr = [];
        foreach ($this->headers as $name=>$val) {
            $headersRawArr[] = $name.": ".$val;
        }
        return $headersRawArr;
    }

    /**
     * @return string
     */
    public function getFullUrl() {
        return $this->apiServerUrl."/".$this->build();
    }

    /**
     * @return string
     */
    private function build() {
        $this->params['ident'] = $this->ident;

        if ($this->requestType == "POST") {
            return $this->baseUrl;
        }
        $resultQuery = $this->baseUrl."?";
        $paramBag = [];
        if ($this->params) {
            foreach ($this->params as $name=>$value) {
                if (!is_null($value) && !is_object($value) ) {
                    $paramBag[] = $name . "=" . urlencode($value);
                }
            }
            $paramsRaw = implode("&", $paramBag);
            $resultQuery .= $paramsRaw . '&sign=' . $this->getSignFromParams($paramsRaw);
        }
        return $resultQuery;
    }

    /**
     * HMAC sign of the request parameters
     * @param $paramsRaw
     * @return string
     */
    function getSignFromParams($paramsRaw) {
        return hash_hmac("sha1", $paramsRaw, $this->secret_key);
    }

    /**
     * @param bool $resultAsBody
     * @return string|array
     */
    public function getPostRequestParams($resultAsBody = false) {
        $paramBag = [];
        foreach ($this->params as $name=>$value) {
            if (!is_null($value)) {
                $paramBag[$name] = $value;
            }
        }
        if ($resultAsBody) {
            $resStr = [];
            foreach ($paramBag as $name=>$value) {
                if (!is_null($value) && !is_object($value) ) {
                    $resStr[] = $name . "=" . urlencode($value);
                }
            }

            $paramsRaw = implode("&", $resStr);
            $paramsRaw .= '&sign=' . $this->getSignFromParams($paramsRaw);

            return $paramsRaw;
        }
        return $paramBag;
    }

}