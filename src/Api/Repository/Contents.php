<?php

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Exception\MissingArgumentException;

class Contents extends AbstractApi
{
    public function all(string $owner, string $repository, string $ref = ''): array
    {
        $format = '/repos/%s/%s/contents';
        if (! empty($ref)) {
            $format = '/repos/%s/%s/contents?ref=%s';
        }

        return $this->get(sprintf($format, rawurlencode($owner), rawurlencode($repository), rawurlencode($ref)));
    }

    public function bulkModify(string $owner, string $repository, array $parameters): array
    {
        if (! isset($parameters['files'])) {
            throw new MissingArgumentException(['files']);
        }

        return $this->post(sprintf('/repos/%s/%s/contents', rawurlencode($owner), rawurlencode($repository)), $parameters);
    }

    public function show(string $owner, string $repository, string $filepath, string $ref = ''): array
    {
        $format = '/repos/%s/%s/contents/%s';
        if (! empty($ref)) {
            $format = '/repos/%s/%s/contents/%s?ref=%s';
        }

        return $this->get(sprintf($format, rawurlencode($owner), rawurlencode($repository), rawurlencode($filepath), rawurlencode($ref)));
    }

    public function update(string $owner, string $repository, string $filepath, array $params)
    {
        if (! isset($params['content'])) {
            throw new MissingArgumentException(['content']);
        }

        if (! isset($params['sha'])) {
            throw new MissingArgumentException(['sha']);
        }

        return $this->put(sprintf('/repos/%s/%s/contents/%s', rawurlencode($owner), rawurlencode($repository), rawurlencode($filepath)), $params);
    }

    public function create(string $owner, string $repository, string $filepath, array $params)
    {
        if (! isset($params['content'])) {
            throw new MissingArgumentException(['content']);
        }

        return $this->post(sprintf('/repos/%s/%s/contents/%s', rawurlencode($owner), rawurlencode($repository), rawurlencode($filepath)), $params);
    }

    public function remove(string $owner, string $repository, string $filepath, array $params)
    {
        if (! isset($params['sha'])) {
            throw new MissingArgumentException(['sha']);
        }

        return $this->delete(sprintf('/repos/%s/%s/contents/%s', rawurlencode($owner), rawurlencode($repository), rawurlencode($filepath)), $params);
    }
}
