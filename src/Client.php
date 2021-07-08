<?php

declare(strict_types=1);

namespace OwenVoke\Gitea;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Api\Admin;
use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\Issue;
use OwenVoke\Gitea\Api\Miscellaneous\Markdown;
use OwenVoke\Gitea\Api\Miscellaneous\SigningKey;
use OwenVoke\Gitea\Api\Miscellaneous\Version;
use OwenVoke\Gitea\Api\Organization;
use OwenVoke\Gitea\Api\PullRequest;
use OwenVoke\Gitea\Api\Repo;
use OwenVoke\Gitea\Api\Settings;
use OwenVoke\Gitea\Api\User;
use OwenVoke\Gitea\Exception\BadMethodCallException;
use OwenVoke\Gitea\Exception\InvalidArgumentException;
use OwenVoke\Gitea\HttpClient\Builder;
use OwenVoke\Gitea\HttpClient\Plugin\Authentication;
use OwenVoke\Gitea\HttpClient\Plugin\PathPrepend;
use Psr\Http\Client\ClientInterface;

/**
 * @method Api\Admin admin()
 * @method Api\CurrentUser currentUser()
 * @method Api\Miscellaneous\Markdown markdown()
 * @method Api\CurrentUser me()
 * @method Api\Issue issue()
 * @method Api\Issue issues()
 * @method Api\Organization organization()
 * @method Api\Organization organizations()
 * @method Api\PullRequest pr()
 * @method Api\PullRequest pullRequest()
 * @method Api\PullRequest pullRequests()
 * @method Api\Repo repo()
 * @method Api\Repo repos()
 * @method Api\Repo repositories()
 * @method Api\Repo repository()
 * @method Api\Settings settings()
 * @method Api\Miscellaneous\SigningKey signingKey()
 * @method Api\User user()
 * @method Api\User users()
 * @method Api\Miscellaneous\Version version()
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
            case 'admin':
                return new Admin($this);

            case 'markdown':
                return new Markdown($this);

            case 'me':
            case 'current_user':
            case 'currentUser':
                return new CurrentUser($this);

            case 'issue':
            case 'issues':
                return new Issue($this);

            case 'organization':
            case 'organizations':
                return new Organization($this);

            case 'pr':
            case 'pullRequest':
            case 'pullRequests':
                return new PullRequest($this);

            case 'repo':
            case 'repos':
            case 'repository':
            case 'repositories':
                return new Repo($this);

            case 'settings':
                return new Settings($this);

            case 'signingKey':
                return new SigningKey($this);

            case 'user':
            case 'users':
                return new User($this);

            case 'version':
                return new Version($this);

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
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
