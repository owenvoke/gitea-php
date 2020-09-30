<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

use OwenVoke\Gitea\Api\CurrentUser\Emails;
use OwenVoke\Gitea\Api\CurrentUser\PublicKeys;

class CurrentUser extends AbstractApi
{
    public function show()
    {
        return $this->get('/user');
    }

    public function emails(): Emails
    {
        return new Emails($this->client);
    }

    public function keys(): PublicKeys
    {
        return new PublicKeys($this->client);
    }
}
