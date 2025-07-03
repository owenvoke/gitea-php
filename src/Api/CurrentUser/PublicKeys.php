<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api\CurrentUser;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Exception\MissingArgumentException;

class PublicKeys extends AbstractApi
{
    public function all(): array
    {
        return $this->get('/user/keys');
    }

    public function show(int $id)
    {
        return $this->get("/user/keys/{$id}");
    }

    public function create(array $params): array
    {
        if (! isset($params['title'], $params['key'])) {
            throw new MissingArgumentException(['title', 'key']);
        }

        return $this->post('/user/keys', $params);
    }

    public function remove(int $id): string
    {
        return $this->delete("/user/keys/{$id}");
    }
}
