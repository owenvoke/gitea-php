<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

class Settings extends AbstractApi
{
    public function api(): array
    {
        return $this->get('/settings/api');
    }

    public function attachment(): array
    {
        return $this->get('/settings/attachment');
    }

    public function repository(): array
    {
        return $this->get('/settings/repository');
    }

    public function ui(): array
    {
        return $this->get('/settings/ui');
    }
}
