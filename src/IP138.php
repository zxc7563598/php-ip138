<?php

namespace Hejunjie\Ip138;

use Hejunjie\Ip138\Exceptions\IP138Exception;
use Hejunjie\Ip138\Services\IpService;
use Hejunjie\Ip138\Services\MobileService;
use Hejunjie\Ip138\Services\QrcodeService;
use Hejunjie\Ip138\Services\WeatherService;

class IP138
{
    const URL_DOMESTIC_HTTP = 'http://api.ipshudi.com';
    const URL_DOMESTIC_HTTPS = 'https://api.ipshudi.com';
    const URL_FOREIGN_HTTP = 'http://api.ip138.com';
    const URL_FOREIGN_HTTPS = 'https://api.ip138.com';

    protected string $baseUrl;
    protected array $tokens = [];

    /**
     * IP138
     * 
     * @param string $baseUrl 接口URL，可以通过 IP138::URL_DOMESTIC_HTTPS 获取
     * @param array $tokens token数组，可选，结构如下：['ipdata'=>'IP查询接口token', 'mobile'=>'手机号码归属地接口token', 'qrcode'=>'二维码扫接口token', 'weather'=>'天气查询接口token']
     * 
     * @return void 
     */
    public function __construct(string $baseUrl, array $tokens = [])
    {
        $this->baseUrl = $baseUrl;
        $this->tokens = $tokens;
    }

    /**
     * IP查询接口
     * 
     * @param string $ip ip地址 例如 117.25.13.123（可选，默认为请求者iP）
     * @param string $datatype txt|jsonp|xml（可选，默认为jsonp）
     * @param string $callback 回调函数 当前参数仅为jsonp格式数据提供（可选，默认为空）
     * @param null|string $token 接口token，若在构造实例时已传入则可不传
     * 
     * @return array IP查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/ip/doc/)
     * @throws IP138Exception 
     */
    public function ipLookup(string $ip, string $datatype = 'jsonp', string $callback = '', ?string $token = null)
    {
        $service = new IpService($this->baseUrl, $token ?? $this->tokens['ipdata'] ?? null);
        return $service->lookup($ip, $datatype, $callback);
    }

    /**
     * 号码归属地查询接口
     * 
     * @param string $mobile 手机号码
     * @param string $datatype txt|jsonp|xml（可选，默认为jsonp）
     * @param string $callback 回调函数 当前参数仅为jsonp格式数据提供（可选，默认为空）
     * @param null|string $token 接口token，若在构造实例时已传入则可不传
     * 
     * @return array 手机号归属地查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/mobile/doc/)
     * @throws IP138Exception 
     */
    public function mobileLookup(string $mobile, string $datatype = 'jsonp', string $callback = '', ?string $token = null)
    {
        $service = new MobileService($this->baseUrl, $token ?? $this->tokens['mobile'] ?? null);
        return $service->lookup($mobile, $datatype, $callback);
    }

    /**
     * 二维码生成接口

     * @param string $text 内容
     * @param string $path 图片存储路径
     * @param string $name 图片名称(可为空，默认随机名称)
     * @param array $config 图片配置，均可为空，配置大概如下：
     * - bg: 背景颜色代码
     * - fg: 前景颜色代码
     * - gc: 渐变颜色代码
     * - el: 纠错等级(h\q\m\l)
     * - w: 尺寸大小(像素)
     * - m: 外边距(像素)
     * - pt: 定位点颜色(外框)
     * - inpt: 定位点颜色(内点)
     * - logo: logo图片
     * - 参数示例: ['bg'=>'ffffff', 'fg'=>'cc0000', 'gc'=>'cc00000', 'el'=>'h', 'w'=>300, 'm'=>30, 'pt'=>'00ff00', 'inpt'=>'000000', 'logo'=>'http://image_url']
     * @param null|string $token 接口token，若在构造实例时已传入则可不传
     * 
     * @return string 图片存储到本地的绝对路径
     * @throws IP138Exception 
     */
    public function qrcodeLookup(string $text, string $path, string $name = '', array $config = [], ?string $token = null)
    {
        $service = new QrcodeService($this->baseUrl, $token ?? $this->tokens['qrcode'] ?? null);
        return $service->lookup($text, $path, $name, $config);
    }

    /**
     * 天气查询接口
     * 
     * @param string $code 行政区划代码 （可选)
     * @param string $ip iP地址 （可选,默认为请求iP,仅当用户没有提供行政区划代码时有效）
     * @param string $callback 回调函数（可选,默认为空）
     * @param integer $type 查询类型 1:今日天气 7:一周天气 (默认今日天气)
     * @param integer $style 天气icon样式 1|2|3
     * @param null|string $token 接口token，若在构造实例时已传入则可不传
     * 
     * @return array 天气查询接口返回数据，详见[IP138接口文档](https://user.ip138.com/weather/doc/)
     * @throws IP138Exception 
     */
    public function weatherLookup(string $code = '', string $ip = '', string $callback = '', int $type = 1, int $style = 3, ?string $token = null)
    {
        $service = new WeatherService($this->baseUrl, $token ?? $this->tokens['weather'] ?? null);
        return $service->lookup($code, $ip, $callback, $type, $style);
    }
}
