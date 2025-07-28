# hejunjie/ip138

<div align="center">
  <a href="./README.md">English</a>｜<a href="./README.zh-CN.md">简体中文</a>
  <hr width="50%"/>
</div>

While working on multiple projects, I often needed to use [IP138's](https://user.ip138.com) APIs — such as IP lookup, mobile attribution, weather queries, QR code generation, and more. However, since there's no official SDK, I had to write the HTTP requests, handle parameters, and process responses manually every time. It became repetitive and a bit tedious after a while.

So I decided to wrap all of IP138's available APIs into this PHP SDK. It makes integration much easier in my own projects, and I’m sharing it here in case it helps others who have similar needs.

**This project has been parsed by Zread. If you need a quick overview of the project, you can click on the number of views to view it：[Understand this project](https://zread.ai/zxc7563598/php-ip138)**

---

## 📦 Installation

Install this package via Composer：

```bash
composer require hejunjie/ip138
```

---

## 🚀 Usage

Since each IP138 API endpoint uses a different token, tokens need to be configured separately for each interface. Two configuration options are provided.

1. **Global configuration**, suitable for more complex scenarios or when multiple API endpoints need to be called.

   ```php
    <?php

    use Hejunjie\Ip138\IP138;

    // IP138 provides multiple API endpoint URLs. You can choose according to your needs:
    // Mainland China HTTP：IP138::URL_DOMESTIC_HTTP
    // Mainland China HTTPS：IP138::URL_DOMESTIC_HTTPS
    // Global HTTP：IP138::URL_FOREIGN_HTTP
    // Global HTTPS：IP138::URL_FOREIGN_HTTPS

    // You don’t need to provide tokens for all interfaces; just pass the token for the specific interface you want to use.
    $ip138 = new IP138(IP138::URL_DOMESTIC_HTTPS, [
        'ipdata' => 'IP Query Token',
        'mobile' => 'Mobile Attribution Token',
        'qrcode' => 'QR Code Generation Token',
        'weather' => 'Weather Query Token'
    ]);
    $ipLookup = $ip138->ipLookup('47.239.212.111');
    print_r($ipLookup);
    // The returned data exactly matches the API documentation.
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

    // Supported methods:
    // IP query interface：$ip138->ipLookup()
    // Mobile attribution query interface：$ip138->mobileLookup()
    // QR code generation interface：$ip138->qrcodeLookup()
    // Weather query interface：$ip138->weatherLookup()
   ```

2. 单独调用，适用于不想过于复杂的调用

   ```php
    <?php

    use Hejunjie\Ip138\IP138;

    $ipLookup = (new IP138(IP138::URL_DOMESTIC_HTTPS))->ipLookup('47.239.212.111','jsonp','','IP Query Token');
    print_r($ipLookup);
    // The returned data exactly matches the API documentation.
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

    // Supported methods:
    // IP query interface：$ip138->ipLookup()
    // Mobile attribution query interface：$ip138->mobileLookup()
    // QR code generation interface：$ip138->qrcodeLookup()
    // Weather query interface：$ip138->weatherLookup()
   ```

---

## 🧠 Purpose & Motivation

The purpose of this library is pretty straightforward: to save time and avoid repetitive work.

IP138’s APIs themselves aren’t complicated, but their request formats and response fields are a bit inconsistent. Every time I needed to write HTTP requests, add tokens, and assemble parameters manually, it became quite repetitive across multiple projects.

I didn’t want to keep copy-pasting the same request logic into different projects or maintain multiple versions separately whenever the API format changed.

So I created this SDK to wrap all the interfaces neatly. Now in my projects, I just call methods and pass parameters without worrying about the details. If IP138 updates their APIs later, I only need to update this SDK once, and all projects using it automatically benefit.

---

## 📮 Contact

If you have any questions, suggestions, or business inquiries, feel free to reach out to me via GitHub Issues.
