<?php

namespace OwenVoke\Gitea\Api\Organization;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Exception\MissingArgumentException;

class Hooks extends AbstractApi
{
    public function all(string $organization): array
    {
        return $this->get(sprintf('/orgs/%s/hooks', rawurlencode($organization)));
    }

    public function show(string $organization, int $id): array
    {
        return $this->get(sprintf('/orgs/%s/hooks/%s', rawurlencode($organization), $id));
    }

    public function create(string $organization, array $params)
    {
        if (! isset($params['name'], $params['config'])) {
            throw new MissingArgumentException(['name', 'config']);
        }

        return $this->post(sprintf('/orgs/%s/hooks', rawurlencode($organization)), $params);
    }

    public function update(string $organization, int $id, array $params)
    {
        if (! isset($params['config'])) {
            throw new MissingArgumentException(['config']);
        }

        return $this->patch(sprintf('/orgs/%s/hooks/%s', rawurlencode($organization), $id), $params);
    }

    public function remove(string $organization, int $id)
    {
        return $this->delete(sprintf('/orgs/%s/hooks/%s', rawurlencode($organization), $id));
    }
}
