<?php

namespace OwenVoke\Gitea\Api\CurrentUser;

use OwenVoke\Gitea\Api\AbstractApi;

class Notifications extends AbstractApi
{
    public function all(array $params = []): array
    {
        return $this->get('/notifications', $params);
    }
}
