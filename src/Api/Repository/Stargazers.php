<?php

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Api\AcceptHeaderTrait;

class Stargazers extends AbstractApi
{
    use AcceptHeaderTrait;

    public function all(string $username, string $repository): array
    {
        return $this->get(sprintf('/repos/%s/%s/stargazers', rawurlencode($username), rawurlencode($repository)));
    }
}
