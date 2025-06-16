<?php

namespace Hejunjie\Ip138\Services;

use Hejunjie\Ip138\Exceptions\IP138Exception;

class BaseService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct(string $baseUrl, ?string $token)
    {
        if (!$token) {
            throw new IP138Exception(static::class . " 的 token 不能为空");
        }
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->token = $token;
    }

    /**
     * 网络请求接口
     * 
     * @param string $endpoint 接口地址
     * @param array $params 请求参数
     * @param array $headers 请求头
     * 
     * @return array 接口相应数据
     * @throws IP138Exception 
     */
    protected function get(string $endpoint, array $params = [], array $headers = []): array
    {
        $defaultHeaders = [
            'token: ' . $params['token'],
        ];
        unset($params['token']);
        $filteredParams = array_filter($params, function ($value) {
            if (is_null($value)) return false;
            if (is_string($value) && trim($value) === '') return false;
            return true;
        });
        $query = http_build_query($filteredParams);
        $url = "{$this->baseUrl}/{$endpoint}?{$query}";
        $ch = curl_init();
        $allHeaders = array_merge($defaultHeaders, $headers);
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $allHeaders,
            CURLOPT_TIMEOUT => 30,
        ]);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($err) {
            throw new IP138Exception("请求失败: $err");
        }
        if ($httpCode !== 200) {
            switch ($httpCode) {
                case 202:
                    throw new IP138Exception("响应失败，可能是无效Token、余额不足、格式错误等问题");
                    break;
                default:
                    throw new IP138Exception("HTTP状态码异常: $httpCode");
                    break;
            }
        }
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new IP138Exception("返回结果解析失败: " . json_last_error_msg());
        }
        return $data;
    }

    /**
     * 图片资源下载
     * 
     * @param string $endpoint 接口地址
     * @param array $params 请求参数
     * @param array $headers 请求头
     * @param string $path 文件存储路径
     * @param string $name 问佳凝成
     * 
     * @return string 图片绝对路径
     * @throws IP138Exception 
     */
    protected function download(string $endpoint, array $params = [], array $headers = [], string $path = '', string $name = ''): string
    {
        $defaultHeaders = [
            'token: ' . $params['token'],
        ];
        unset($params['token']);
        $filteredParams = array_filter($params, function ($value) {
            if (is_null($value)) return false;
            if (is_string($value) && trim($value) === '') return false;
            return true;
        });
        $query = http_build_query($filteredParams);
        $url = "{$this->baseUrl}/{$endpoint}?{$query}";
        $ch = curl_init();
        $allHeaders = array_merge($defaultHeaders, $headers);
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $allHeaders,
            CURLOPT_TIMEOUT => 30,
        ]);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($err) {
            throw new IP138Exception("请求失败: $err");
        }
        if ($httpCode !== 200) {
            switch ($httpCode) {
                case 202:
                    throw new IP138Exception("响应失败，可能是无效Token、余额不足、格式错误等问题");
                default:
                    throw new IP138Exception("HTTP状态码异常: $httpCode");
            }
        }
        // 检测图片类型
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($response);
        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            'image/bmp'  => 'bmp',
            'image/svg+xml' => 'svg',
        ];
        $extension = $extensionMap[$mimeType] ?? 'jpg';
        // 确定文件名
        if (!$name) {
            $name = uniqid('ip138_', true);
        }
        $filename = $name . '.' . $extension;
        // 确保目录存在
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true) && !is_dir($path)) {
                throw new IP138Exception("无法创建目录: $path");
            }
        }
        $filePath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        if (file_put_contents($filePath, $response) === false) {
            throw new IP138Exception("文件保存失败: $filePath");
        }
        return realpath($filePath) ?: $filePath;
    }
}
