<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;

class Commits extends AbstractApi
{
    public function all(string $username, string $repository, array $parameters): array
    {
        return $this->get(sprintf('/repos/%s/%s/commits', rawurlencode($username), rawurlencode($repository)), $parameters);
    }

    public function show(string $username, string $repository, string $sha): array
    {
        return $this->get(sprintf('/repos/%s/%s/git/commits/%s', rawurlencode($username), rawurlencode($repository), rawurlencode($sha)));
    }
}
