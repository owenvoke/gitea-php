<?php

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;

class Stargazers extends AbstractApi
{
    public function all(string $username, string $repository): array
    {
        return $this->get(sprintf('/repos/%s/%s/stargazers', rawurlencode($username), rawurlencode($repository)));
    }
}
