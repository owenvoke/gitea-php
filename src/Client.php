<?php

declare(strict_types=1);

namespace OwenVoke\Gitea;

use Http\Client\HttpClient;
use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\ApiInterface;
use OwenVoke\Gitea\HttpClient\Builder;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use OwenVoke\Gitea\HttpClient\Plugin\PathPrepend;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use OwenVoke\Gitea\Exception\BadMethodCallException;
use OwenVoke\Gitea\HttpClient\Plugin\Authentication;
use OwenVoke\Gitea\Exception\InvalidArgumentException;

/**
 * @author Joseph Bielawski <stloyd@gmail.com>
 */
final class Client
{
    public const AUTH_ACCESS_TOKEN = 'access_token_header';

    public string $apiVersion;
    private Builder $httpClientBuilder;

    public function __construct(Builder $httpClientBuilder = null, ?string $apiVersion = null, ?string $enterpriseUrl = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri('https://gitea.com')));
        $builder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => 'gitea-php (https://github.com/owenvoke/gitea-php)',
        ]));

        $this->apiVersion = $apiVersion ?: 'v1';
        $builder->addHeaderValue('Accept', 'application/json');
        $builder->addPlugin(new PathPrepend(sprintf('/api/%s', $this->getApiVersion())));

        if ($enterpriseUrl) {
            $this->setEnterpriseUrl($enterpriseUrl);
        }
    }

    public static function createWithHttpClient(HttpClient $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /** @throws InvalidArgumentException */
    public function api(string $name): ApiInterface
    {
        switch ($name) {
            case 'me':
            case 'current_user':
            case 'currentUser':
                $api = new CurrentUser($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    public function authenticate(string $tokenOrLogin, ?string $password = null, ?string $authMethod = null): void
    {
        if (null === $password && null === $authMethod) {
            throw new InvalidArgumentException('You need to specify authentication method!');
        }

        if (null === $authMethod && $password === self::AUTH_ACCESS_TOKEN) {
            $authMethod = $password;
            $password = null;
        }

        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($tokenOrLogin, $password, $authMethod));
    }

    private function setEnterpriseUrl(string $enterpriseUrl): void
    {
        $builder = $this->getHttpClientBuilder();
        $builder->removePlugin(AddHostPlugin::class);
        $builder->removePlugin(PathPrepend::class);

        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($enterpriseUrl)));
        $builder->addPlugin(new PathPrepend(sprintf('/api/%s', $this->getApiVersion())));
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function __call(string $name, array $args): ApiInterface
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name), $e->getCode(), $e);
        }
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
