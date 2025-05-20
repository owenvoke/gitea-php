<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api\Miscellaneous;

use OwenVoke\Gitea\Api\AbstractApi;

class Version extends AbstractApi
{
    public function show(): array
    {
        return $this->get('/version');
    }
}
