<?php

namespace OwenVoke\Gitea\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\VersionBridgePlugin;
use Http\Promise\Promise;
use OwenVoke\Gitea\Client;
use OwenVoke\Gitea\Exception\RuntimeException;
use Psr\Http\Message\RequestInterface;

final class Authentication implements Plugin
{
    use VersionBridgePlugin;

    private string $tokenOrLogin;

    /** @phpstan-ignore property.onlyWritten */
    private ?string $password;

    private ?string $method;

    /**
     * @param  string  $tokenOrLogin  Gitea private token/username/client ID
     * @param  string|null  $password  Gitea password/secret (optionally can contain $method)
     * @param  string|null  $method  One of the AUTH_* class constants
     */
    public function __construct(string $tokenOrLogin, ?string $password, ?string $method)
    {
        $this->tokenOrLogin = $tokenOrLogin;
        $this->password = $password;
        $this->method = $method;
    }

    public function doHandleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $request->withHeader(
            'Authorization',
            $this->getAuthorizationHeader()
        );

        return $next($request);
    }

    private function getAuthorizationHeader(): string
    {
        switch ($this->method) {
            case Client::AUTH_ACCESS_TOKEN:
                return sprintf('token %s', $this->tokenOrLogin);
            default:
                throw new RuntimeException(sprintf('%s not yet implemented', $this->method));
        }
    }
}
