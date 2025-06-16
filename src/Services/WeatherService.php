<?php

namespace Hejunjie\Ip138\Services;

use Hejunjie\Ip138\Exceptions\IP138Exception;

class WeatherService extends BaseService
{
    /**
     * 请求接口
     * 
     * @param string $code 行政区划代码 （可选)
     * @param string $ip iP地址 （可选,默认为请求iP,仅当用户没有提供行政区划代码时有效）
     * @param string $callback 回调函数（可选,默认为空）
     * @param integer $type 查询类型 1:今日天气 7:一周天气 (默认今日天气)
     * @param integer $style 天气icon样式 1|2|3
     * 
     * @return array 天气查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/weather/doc/)
     * @throws IP138Exception 
     */
    public function lookup(string $code = '', string $ip = '', string $callback = '', $type = 1, $style = 3): array
    {
        return $this->get('weather/', [
            'code' => $code,
            'ip' => $ip,
            'callback' => $callback,
            'type' => $type,
            'style' => $style,
            'token' => $this->token
        ]);
    }
}
