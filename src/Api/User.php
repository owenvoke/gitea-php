<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

class User extends AbstractApi
{
    public function show(string $username): array
    {
        return $this->get(sprintf('/users/%s', rawurlencode($username)));
    }

    public function following(string $username, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->get(sprintf('/users/%s/following', rawurlencode($username)), $parameters, $requestHeaders);
    }

    public function followers(string $username, array $parameters = [], array $requestHeaders = []): array
    {
        return $this->get(sprintf('/users/%s/followers', rawurlencode($username)), $parameters, $requestHeaders);
    }

    public function starred(string $username, int $page = 1, int $perPage = 30): array
    {
        return $this->get(sprintf('/users/%s/starred', rawurlencode($username)), [
            'page' => $page,
            'limit' => $perPage,
        ]);
    }

    public function subscriptions(string $username): array
    {
        return $this->get(sprintf('/users/%s/subscriptions', rawurlencode($username)));
    }

    public function repositories(string $username): array
    {
        return $this->get(sprintf('/users/%s/repos', rawurlencode($username)));
    }

    public function myRepositories(array $parameters = []): array
    {
        return $this->get('/user/repos', $parameters);
    }

    public function keys(string $username): array
    {
        return $this->get(sprintf('/users/%s/keys', rawurlencode($username)));
    }

    public function gpgKeys(string $username): array
    {
        return $this->get(sprintf('/users/%s/gpg_keys', rawurlencode($username)));
    }
}
