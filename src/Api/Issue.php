<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

use OwenVoke\Gitea\Exception\MissingArgumentException;

class Issue extends AbstractApi
{
    public function all(string $username, string $repository, array $parameters = []): array
    {
        return $this->get(sprintf('/repos/%s/%s/issues', rawurlencode($username), rawurlencode($repository)), $parameters);
    }

    public function show(string $username, string $repository, int $id): array
    {
        return $this->get(sprintf('/repos/%s/%s/issues/%s', rawurlencode($username), rawurlencode($repository), $id));
    }

    public function create(string $username, string $repository, array $parameters)
    {
        if (! isset($parameters['title'])) {
            throw new MissingArgumentException(['title']);
        }

        return $this->post(sprintf('/repos/%s/%s/issues', rawurlencode($username), rawurlencode($repository)), $parameters);
    }
}
