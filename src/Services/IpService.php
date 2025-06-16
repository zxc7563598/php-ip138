<?php

namespace Hejunjie\Ip138\Services;

use Hejunjie\Ip138\Exceptions\IP138Exception;

class IpService extends BaseService
{
    /**
     * 请求接口
     * 
     * @param string $ip ip地址 例如 117.25.13.123（可选，默认为请求者iP）
     * @param string $datatype txt|jsonp|xml（可选，默认为jsonp）
     * @param string $callback 回调函数 当前参数仅为jsonp格式数据提供（可选，默认为空）
     * 
     * @return array IP查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/ip/doc/)
     * @throws IP138Exception 
     */
    public function lookup(string $ip = '', string $datatype = 'jsonp', string $callback = ''): array
    {
        return $this->get('ipdata/', [
            'ip' => $ip,
            'datatype' => $datatype,
            'callback' => $callback,
            'token' => $this->token
        ]);
    }
}
