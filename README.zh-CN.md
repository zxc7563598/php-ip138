# hejunjie/ip138

<div align="center">
  <a href="./README.md">English</a>｜<a href="./README.zh-CN.md">简体中文</a>
  <hr width="50%"/>
</div>

我在做多个项目时，都需要用到 [IP138](https://user.ip138.com/) 提供的接口，比如 IP 查询、手机号归属地、天气查询、二维码生成等等。但官方并没有提供 SDK，每次都要自己去写一遍 HTTP 请求、拼接参数、处理响应，重复性比较高，写着写着也有点烦了。

所以干脆抽了一层，把 IP138 目前开放的接口统一封装成了这个 PHP SDK，平时在自己的项目里用着方便，顺手也把它整理出来放在这里，可能也能帮到和我有类似需求的人。

---

## 📦 安装方式

使用 Composer 安装本库：

```bash
composer require hejunjie/ip138
```

---

## 🚀 使用方式

因为 IP138 每一个接口的 Token 都是不同的，因此需要为每一个接口进行 Token 的配置，提供了两种方案

1. **全局配置**，适用于较为复杂，或者需要调用多个接口的场景

   ```php
    <?php

    use Hejunjie\Ip138\IP138;

    // IP138 接口给了多个接口地址，可以根据自己的情况进行选择，分别为：
    // 国内HTTP：IP138::URL_DOMESTIC_HTTP
    // 国内HTTPS：IP138::URL_DOMESTIC_HTTPS
    // 全球HTTP：IP138::URL_FOREIGN_HTTP
    // 全球HTTPS：IP138::URL_FOREIGN_HTTPS

    // token参数并非需要全部传入，需要使用什么接口则传递什么接口的token就可以
    $ip138 = new IP138(IP138::URL_DOMESTIC_HTTPS, [
        'ipdata' => 'ip查询token',
        'mobile' => '手机号归属地查询token',
        'qrcode' => '二维码生成token',
        'weather' => '天气查询token'
    ]);
    $ipLookup = $ip138->ipLookup('47.239.212.111');
    print_r($ipLookup);
    // 返回数据与接口文档完全相同
    // Array
    // (
    //     [ret] => ok
    //     [ip] => 47.239.212.111
    //     [data] => Array
    //         (
    //             [0] => 中国
    //             [1] => 香港
    //             [2] => 香港
    //             [3] =>
    //             [4] => 阿里云
    //             [5] => 999077
    //             [6] => 00852
    //             [7] => 数据中心
    //         )
    // )

    // 支持的方法：
    // IP查询接口：$ip138->ipLookup()
    // 号码归属地查询接口：$ip138->mobileLookup()
    // 二维码生成接口：$ip138->qrcodeLookup()
    // 天气查询接口：$ip138->weatherLookup()
   ```

2. 单独调用，适用于不想过于复杂的调用

   ```php
    <?php

    use Hejunjie\Ip138\IP138;

    $ipLookup = (new IP138(IP138::URL_DOMESTIC_HTTPS))->ipLookup('47.239.212.111','jsonp','','ip查询token');
    print_r($ipLookup);
    // 返回数据与接口文档完全相同
    // Array
    // (
    //     [ret] => ok
    //     [ip] => 47.239.212.111
    //     [data] => Array
    //         (
    //             [0] => 中国
    //             [1] => 香港
    //             [2] => 香港
    //             [3] =>
    //             [4] => 阿里云
    //             [5] => 999077
    //             [6] => 00852
    //             [7] => 数据中心
    //         )
    // )

    // 支持的方法：
    // IP查询接口：$ip138->ipLookup()
    // 号码归属地查询接口：$ip138->mobileLookup()
    // 二维码生成接口：$ip138->qrcodeLookup()
    // 天气查询接口：$ip138->weatherLookup()
   ```

---

## 🧠 用途 & 初衷

这个库的定位其实很简单：就是为了偷懒。

IP138 的接口本身没什么复杂逻辑，但它的请求格式和响应字段稍微有点各自为政，而且每次要自己去写网络请求、加 token、拼参数，长期下来在多个项目里重复度挺高。

我不太希望每次在不同项目里都去复制粘贴那套请求逻辑，更不希望因为某次格式调整，得在多个项目里分头维护。

所以就做了这么一个 SDK，把所有接口都封装好，项目里直接按方法调用，传参数就能用，基本上不用关心接口细节。以后如果 IP138 那边有接口更新，我只需要在这里维护一份逻辑，所有用到这个 SDK 的项目都会自动跟上。

---

## 📮 联系方式

如有问题、建议或合作意向，欢迎通过 GitHub Issue 与我联系。
