<?php

declare(strict_types=1);

namespace OwenVoke\Gitea;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\Organization;
use OwenVoke\Gitea\Api\PullRequest;
use OwenVoke\Gitea\Api\Repo;
use OwenVoke\Gitea\Api\User;
use OwenVoke\Gitea\Exception\BadMethodCallException;
use OwenVoke\Gitea\Exception\InvalidArgumentException;
use OwenVoke\Gitea\HttpClient\Builder;
use OwenVoke\Gitea\HttpClient\Plugin\Authentication;
use OwenVoke\Gitea\HttpClient\Plugin\PathPrepend;
use Psr\Http\Client\ClientInterface;

/**
 * @method Api\CurrentUser currentUser()
 * @method Api\CurrentUser me()
 * @method Api\Miscellaneous\Markdown markdown()
 * @method Api\Miscellaneous\Version version()
 * @method Api\Organization organization()
 * @method Api\Organization organizations()
 * @method Api\PullRequest pr()
 * @method Api\PullRequest pullRequest()
 * @method Api\PullRequest pullRequests()
 * @method Api\Repo repo()
 * @method Api\Repo repos()
 * @method Api\Repo repository()
 * @method Api\Repo repositories()
 * @method Api\User user()
 * @method Api\User users()
 */
final class Client
{
    public const AUTH_ACCESS_TOKEN = 'access_token_header';

    public string $apiVersion;
    private ?string $enterpriseUrl = null;
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

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /** @throws InvalidArgumentException */
    public function api(string $name): AbstractApi
    {
        switch ($name) {
            case 'me':
            case 'current_user':
            case 'currentUser':
                $api = new CurrentUser($this);
                break;

            case 'organization':
            case 'organizations':
                $api = new Organization($this);
                break;

            case 'pr':
            case 'pullRequest':
            case 'pullRequests':
                $api = new PullRequest($this);
                break;

            case 'repo':
            case 'repos':
            case 'repository':
            case 'repositories':
                $api = new Repo($this);
                break;

            case 'user':
            case 'users':
                $api = new User($this);
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
        $this->enterpriseUrl = $enterpriseUrl;

        $builder = $this->getHttpClientBuilder();
        $builder->removePlugin(AddHostPlugin::class);
        $builder->removePlugin(PathPrepend::class);

        $builder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($this->getEnterpriseUrl())));
        $builder->addPlugin(new PathPrepend(sprintf('/api/%s', $this->getApiVersion())));
    }

    public function getEnterpriseUrl(): ?string
    {
        return $this->enterpriseUrl;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function __call(string $name, array $args): AbstractApi
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
