<?php

namespace Hejunjie\Ip138\Services;

use Hejunjie\Ip138\Exceptions\IP138Exception;

class QrcodeService extends BaseService
{
    /**
     * 请求接口
     * 
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
     * 
     * @return string 图片存储到本地的绝对路径
     * @throws IP138Exception 
     */
    public function lookup(string $text, string $path, string $name = '', array $config = []): string
    {
        return $this->download('qrcode/', array_merge([
            'text' => $text,
            'token' => $this->token
        ], $config), [], $path, $name);
    }
}
