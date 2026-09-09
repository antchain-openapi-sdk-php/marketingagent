<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AntChain\MARKETINGAGENT;

use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Exception\TeaError;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Request;
use AntChain\Util\UtilClient;
use AlibabaCloud\Tea\RpcUtils\RpcUtils;

use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AntChain\MARKETINGAGENT\Models\ExecChatCreativeRequest;
use AntChain\MARKETINGAGENT\Models\ExecChatCreativeResponse;
use AntChain\MARKETINGAGENT\Models\ExecCreativeChatRequest;
use AntChain\MARKETINGAGENT\Models\ExecCreativeChatResponse;
use AntChain\MARKETINGAGENT\Models\QueryCreativeResultRequest;
use AntChain\MARKETINGAGENT\Models\QueryCreativeResultResponse;
use AntChain\MARKETINGAGENT\Models\QueryTaskCreditRequest;
use AntChain\MARKETINGAGENT\Models\QueryTaskCreditResponse;
use AntChain\MARKETINGAGENT\Models\SendMessageRequest;
use AntChain\MARKETINGAGENT\Models\SendMessageResponse;
use AntChain\MARKETINGAGENT\Models\GetTaskRequest;
use AntChain\MARKETINGAGENT\Models\GetTaskResponse;
use AntChain\MARKETINGAGENT\Models\GetComsumeJdRequest;
use AntChain\MARKETINGAGENT\Models\GetComsumeJdResponse;

class Client {
    protected $_endpoint;

    protected $_regionId;

    protected $_accessKeyId;

    protected $_accessKeySecret;

    protected $_protocol;

    protected $_userAgent;

    protected $_readTimeout;

    protected $_connectTimeout;

    protected $_httpProxy;

    protected $_httpsProxy;

    protected $_socks5Proxy;

    protected $_socks5NetWork;

    protected $_noProxy;

    protected $_maxIdleConns;

    protected $_securityToken;

    protected $_maxIdleTimeMillis;

    protected $_keepAliveDurationMillis;

    protected $_maxRequests;

    protected $_maxRequestsPerHost;

    /**
     * Init client with Config
     * @param config config contains the necessary information to create a client
     */
    public function __construct($config){
        if (Utils::isUnset($config)) {
            throw new TeaError([
                "code" => "ParameterMissing",
                "message" => "'config' can not be unset"
            ]);
        }
        $this->_accessKeyId = $config->accessKeyId;
        $this->_accessKeySecret = $config->accessKeySecret;
        $this->_securityToken = $config->securityToken;
        $this->_endpoint = $config->endpoint;
        $this->_protocol = $config->protocol;
        $this->_userAgent = $config->userAgent;
        $this->_readTimeout = Utils::defaultNumber($config->readTimeout, 20000);
        $this->_connectTimeout = Utils::defaultNumber($config->connectTimeout, 20000);
        $this->_httpProxy = $config->httpProxy;
        $this->_httpsProxy = $config->httpsProxy;
        $this->_noProxy = $config->noProxy;
        $this->_socks5Proxy = $config->socks5Proxy;
        $this->_socks5NetWork = $config->socks5NetWork;
        $this->_maxIdleConns = Utils::defaultNumber($config->maxIdleConns, 60000);
        $this->_maxIdleTimeMillis = Utils::defaultNumber($config->maxIdleTimeMillis, 5);
        $this->_keepAliveDurationMillis = Utils::defaultNumber($config->keepAliveDurationMillis, 5000);
        $this->_maxRequests = Utils::defaultNumber($config->maxRequests, 100);
        $this->_maxRequestsPerHost = Utils::defaultNumber($config->maxRequestsPerHost, 100);
    }

    /**
     * Encapsulate the request and invoke the network
     * @param string $version
     * @param string $action api name
     * @param string $protocol http or https
     * @param string $method e.g. GET
     * @param string $pathname pathname of every api
     * @param mixed[] $request which contains request params
     * @param string[] $headers
     * @param RuntimeOptions $runtime which controls some details of call api, such as retry times
     * @return array the response
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     */
    public function doRequest($version, $action, $protocol, $method, $pathname, $request, $headers, $runtime){
        $runtime->validate();
        $_runtime = [
            "timeouted" => "retry",
            "readTimeout" => Utils::defaultNumber($runtime->readTimeout, $this->_readTimeout),
            "connectTimeout" => Utils::defaultNumber($runtime->connectTimeout, $this->_connectTimeout),
            "httpProxy" => Utils::defaultString($runtime->httpProxy, $this->_httpProxy),
            "httpsProxy" => Utils::defaultString($runtime->httpsProxy, $this->_httpsProxy),
            "noProxy" => Utils::defaultString($runtime->noProxy, $this->_noProxy),
            "maxIdleConns" => Utils::defaultNumber($runtime->maxIdleConns, $this->_maxIdleConns),
            "maxIdleTimeMillis" => $this->_maxIdleTimeMillis,
            "keepAliveDuration" => $this->_keepAliveDurationMillis,
            "maxRequests" => $this->_maxRequests,
            "maxRequestsPerHost" => $this->_maxRequestsPerHost,
            "retry" => [
                "retryable" => $runtime->autoretry,
                "maxAttempts" => Utils::defaultNumber($runtime->maxAttempts, 3)
            ],
            "backoff" => [
                "policy" => Utils::defaultString($runtime->backoffPolicy, "no"),
                "period" => Utils::defaultNumber($runtime->backoffPeriod, 1)
            ],
            "ignoreSSL" => $runtime->ignoreSSL,
            // DataPart represents a structured blob.
        ];
        $_lastRequest = null;
        $_lastException = null;
        $_now = time();
        $_retryTimes = 0;
        while (Tea::allowRetry(@$_runtime["retry"], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime["backoff"], $_retryTimes);
                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;
            try {
                $_request = new Request();
                $_request->protocol = Utils::defaultString($this->_protocol, $protocol);
                $_request->method = $method;
                $_request->pathname = $pathname;
                $_request->query = [
                    "method" => $action,
                    "version" => $version,
                    "sign_type" => "HmacSHA1",
                    "req_time" => UtilClient::getTimestamp(),
                    "req_msg_id" => UtilClient::getNonce(),
                    "access_key" => $this->_accessKeyId,
                    "base_sdk_version" => "TeaSDK-2.0",
                    "sdk_version" => "1.0.8",
                    "_prod_code" => "MARKETINGAGENT",
                    "_prod_channel" => "default"
                ];
                if (!Utils::empty_($this->_securityToken)) {
                    $_request->query["security_token"] = $this->_securityToken;
                }
                $_request->headers = Tea::merge([
                    "host" => Utils::defaultString($this->_endpoint, "openapi.antchain.antgroup.com"),
                    "user-agent" => Utils::getUserAgent($this->_userAgent)
                ], $headers);
                $tmp = Utils::anyifyMapValue(RpcUtils::query($request));
                $_request->body = Utils::toFormString($tmp);
                $_request->headers["content-type"] = "application/x-www-form-urlencoded";
                $signedParam = Tea::merge($_request->query, RpcUtils::query($request));
                $_request->query["sign"] = UtilClient::getSignature($signedParam, $this->_accessKeySecret);
                $_lastRequest = $_request;
                $_response= Tea::send($_request, $_runtime);
                $raw = Utils::readAsString($_response->body);
                $obj = Utils::parseJSON($raw);
                $res = Utils::assertAsMap($obj);
                $resp = Utils::assertAsMap(@$res["response"]);
                if (UtilClient::hasError($raw, $this->_accessKeySecret)) {
                    throw new TeaError([
                        "message" => @$resp["result_msg"],
                        "data" => $resp,
                        "code" => @$resp["result_code"]
                    ]);
                }
                return $resp;
            }
            catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }
                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * Description: 创意素材中心chat生图接口
     * Summary: 创意素材中心chat生图接口
     * @param ExecChatCreativeRequest $request
     * @return ExecChatCreativeResponse
     */
    public function execChatCreative($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->execChatCreativeEx($request, $headers, $runtime);
    }

    /**
     * Description: 创意素材中心chat生图接口
     * Summary: 创意素材中心chat生图接口
     * @param ExecChatCreativeRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return ExecChatCreativeResponse
     */
    public function execChatCreativeEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return ExecChatCreativeResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.chat.creative.exec", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: 创意素材chat接口
     * Summary: 创意素材chat接口
     * @param ExecCreativeChatRequest $request
     * @return ExecCreativeChatResponse
     */
    public function execCreativeChat($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->execCreativeChatEx($request, $headers, $runtime);
    }

    /**
     * Description: 创意素材chat接口
     * Summary: 创意素材chat接口
     * @param ExecCreativeChatRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return ExecCreativeChatResponse
     */
    public function execCreativeChatEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return ExecCreativeChatResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.creative.chat.exec", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: chat结果查询接口
     * Summary: chat结果查询接口
     * @param QueryCreativeResultRequest $request
     * @return QueryCreativeResultResponse
     */
    public function queryCreativeResult($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->queryCreativeResultEx($request, $headers, $runtime);
    }

    /**
     * Description: chat结果查询接口
     * Summary: chat结果查询接口
     * @param QueryCreativeResultRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return QueryCreativeResultResponse
     */
    public function queryCreativeResultEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return QueryCreativeResultResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.creative.result.query", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: credit查询
     * Summary: credit查询
     * @param QueryTaskCreditRequest $request
     * @return QueryTaskCreditResponse
     */
    public function queryTaskCredit($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->queryTaskCreditEx($request, $headers, $runtime);
    }

    /**
     * Description: credit查询
     * Summary: credit查询
     * @param QueryTaskCreditRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return QueryTaskCreditResponse
     */
    public function queryTaskCreditEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return QueryTaskCreditResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.task.credit.query", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: 摩斯营销智能体A2A开放接口：message:send
     * Summary: message:send
     * @param SendMessageRequest $request
     * @return SendMessageResponse
     */
    public function sendMessage($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->sendMessageEx($request, $headers, $runtime);
    }

    /**
     * Description: 摩斯营销智能体A2A开放接口：message:send
     * Summary: message:send
     * @param SendMessageRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return SendMessageResponse
     */
    public function sendMessageEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return SendMessageResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.message.send", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: 摩斯营销智能体A2A开放接口：task:get
     * Summary: 摩斯营销智能体A2A开放接口：task:get
     * @param GetTaskRequest $request
     * @return GetTaskResponse
     */
    public function getTask($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->getTaskEx($request, $headers, $runtime);
    }

    /**
     * Description: 摩斯营销智能体A2A开放接口：task:get
     * Summary: 摩斯营销智能体A2A开放接口：task:get
     * @param GetTaskRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return GetTaskResponse
     */
    public function getTaskEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return GetTaskResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.task.get", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }

    /**
     * Description: 京东微信核销数据回调
     * Summary: 京东微信核销数据回调
     * @param GetComsumeJdRequest $request
     * @return GetComsumeJdResponse
     */
    public function getComsumeJd($request){
        $runtime = new RuntimeOptions([]);
        $headers = [];
        return $this->getComsumeJdEx($request, $headers, $runtime);
    }

    /**
     * Description: 京东微信核销数据回调
     * Summary: 京东微信核销数据回调
     * @param GetComsumeJdRequest $request
     * @param string[] $headers
     * @param RuntimeOptions $runtime
     * @return GetComsumeJdResponse
     */
    public function getComsumeJdEx($request, $headers, $runtime){
        Utils::validateModel($request);
        return GetComsumeJdResponse::fromMap($this->doRequest("1.0", "antcloud.marketingagent.comsume.jd.get", "HTTPS", "POST", "/gateway.do", Tea::merge($request), $headers, $runtime));
    }
}
