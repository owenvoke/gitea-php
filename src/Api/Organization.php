<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

class Organization extends AbstractApi
{
    public function all(int $page = 1, int $limit = 30)
    {
        return $this->get('/orgs', [
            'page' => $page,
            'limit' => $limit,
        ]);
    }

    public function show(string $organization)
    {
        return $this->get(sprintf('/orgs/%s', rawurlencode($organization)));
    }

    public function update(string $organization, array $parameters)
    {
        return $this->patch(sprintf('/orgs/%s', rawurlencode($organization)), $parameters);
    }

    public function repositories(string $organization, int $page = 1, int $limit = 30)
    {
        $parameters = [
            'page' => $page,
            'limit' => $limit,
        ];

        return $this->get(sprintf('/orgs/%s/repos', rawurlencode($organization)), $parameters);
    }
}
