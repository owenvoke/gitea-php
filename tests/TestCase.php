<?php

namespace OwenVoke\Gitea\Tests;

use Http\Client\HttpClient;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionMethod;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected string $apiClass;

    protected function getApiMock(): MockObject
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->onlyMethods(['sendRequest'])
            ->getMock();

        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $client = \OwenVoke\Gitea\Client::createWithHttpClient($httpClient);

        return $this->getMockBuilder($this->apiClass)
            ->onlyMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    protected function getMethod(object $object, string $methodName): ReflectionMethod
    {
        $method = new ReflectionMethod($object, $methodName);
        $method->setAccessible(true);

        return $method;
    }
}
