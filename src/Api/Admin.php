<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

class Admin extends AbstractApi
{
    public function organizations(array $parameters = []): array
    {
        return $this->get('/admin/orgs', $parameters);
    }

    public function users(array $parameters = []): array
    {
        return $this->get('/admin/users', $parameters);
    }

    public function unadopted(array $parameters = []): array
    {
        return $this->get('/admin/unadopted');
    }

    public function cron(array $parameters = []): array
    {
        return $this->get('/admin/cron', $parameters);
    }
}
