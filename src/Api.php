<?php

namespace Wored\HangZhouHaiXiaoSdk;

use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    public $config;
    public $timestamp;

    /**
     * Api constructor.
     * @param $appkey
     * @param $appsecret
     * @param $sid
     * @param $baseUrl
     */
    public function __construct(HaiXiaoSdk $haiXiaoSdk)
    {
        $this->config = $haiXiaoSdk->getConfig();
    }

    /**
     * 发送接口请求
     * @param string $msgtype 报文类型
     * @param array $order 订单数据
     * @return mixed
     */
    public function request(string $msgtype, array $data)
    {
        $this->timestamp = date('Y-m-d H:i:s');
        $params = [
            'userid'    => $this->config['userid'],
            'timestamp' => urlencode($this->timestamp),
            'sign'      => $this->sign(),
            'msgtype'   => $msgtype,
        ];
        $requestUrl = $this->config['rootUrl'] . '?' . http_build_query($params);
        $response = $this->https_request($requestUrl, $this->paramToXml($data));
        $objectxml = simplexml_load_string($response);
        $xmljson = json_encode($objectxml);
        $xmlarray = json_decode($xmljson, true);
        return $xmlarray;
    }

    /**
     * http 请求
     * @param $url
     * @param null $data
     * @return mixed
     */
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 生成签名
     * @param array $request_params
     * @return string
     */
    public function sign()
    {
        return md5($this->config['userid'] . $this->config['password'] . $this->timestamp);
    }

    /**
     * @param $param
     * @param bool $root
     * @return string
     */
    public function paramToXml($param, $root = true)
    {
        if ($root) {
            $xml = '<?xml version="1.0" encoding="utf-8"?>';
        } else {
            $xml = '';
        }
        foreach ($param as $key => $vo) {
            if ($key === 'attributes') {//判断是否是属性字段
                continue;
            }
            if (!is_numeric($key)) {
                $xml .= "<{$key}";
                if (!empty($vo['attributes'])) {//添加属性
                    foreach ($vo['attributes'] as $item => $attribute) {
                        $xml .= " {$item}=\"{$attribute}\"";
                    }
                }
                $xml .= '>';
            }
            if (is_array($vo) and count($vo) > 0) {
                $xml .= $this->paramToXml($vo, false);
            } else {
                $xml .= $vo;
            }
            if (!is_numeric($key)) {
                $xml .= "</{$key}>";
            }
        }
        return $xml;
    }
}