<?php

namespace Hejunjie\Ip138\Services;

use Hejunjie\Ip138\Exceptions\IP138Exception;

class MobileService extends BaseService
{
    /**
     * 请求接口
     * 
     * @param string $mobile 手机号码
     * @param string $datatype txt|jsonp|xml（可选，默认为jsonp）
     * @param string $callback 回调函数 当前参数仅为jsonp格式数据提供（可选，默认为空）
     * 
     * @return array 手机号归属地查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/mobile/doc/)
     * @throws IP138Exception 
     */
    public function lookup(string $mobile = '', string $datatype = 'jsonp', string $callback = ''): array
    {
        return $this->get('mobile/', [
            'mobile' => $mobile,
            'datatype' => $datatype,
            'callback' => $callback,
            'token' => $this->token
        ]);
    }
}
