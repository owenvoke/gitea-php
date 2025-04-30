<?php

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Exception\MissingArgumentException;

class Contents extends AbstractApi
{
    public function all(string $owner, string $repository, string $ref = ''): array
    {
        $format = '/repos/%s/%s/contents';
        if (!empty($ref)) {
            $format = '/repos/%s/%s/contents?ref=%s';
        }

        return $this->get(sprintf($format, rawurlencode($owner), rawurlencode($repository), rawurlencode($ref)));
    }

    public function create(string $owner, string $repository, array $parameters): array
    {
        if (! isset($parameters['files'])) {
            throw new MissingArgumentException(['files']);
        }

        return $this->post(sprintf('/repos/%s/%s/contents', rawurlencode($owner), rawurlencode($repository)), $parameters);
    }
}
