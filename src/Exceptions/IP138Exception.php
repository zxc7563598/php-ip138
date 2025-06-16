<?php

namespace Hejunjie\Ip138\Exceptions;

class IP138Exception extends \Exception
{
    protected ?array $responseData = null;

    public function __construct(string $message = "", int $code = 0, ?array $responseData = null, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->responseData = $responseData;
    }

    /**
     * 获取原始返回数据（如有）
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }
}
