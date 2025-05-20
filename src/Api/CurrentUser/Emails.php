<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api\CurrentUser;

use OwenVoke\Gitea\Api\AbstractApi;
use OwenVoke\Gitea\Exception\InvalidArgumentException;

class Emails extends AbstractApi
{
    public function all(): array
    {
        return $this->get('/user/emails');
    }

    /** @param string|array<int,string> $emails */
    public function add($emails): array
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (count($emails) === 0) {
            throw new InvalidArgumentException('The user emails parameter should be a single email or an array of emails');
        }

        return $this->post('/user/emails', ['emails' => $emails]);
    }

    /** @param string|array<int,string> $emails */
    public function remove($emails): string
    {
        if (is_string($emails)) {
            $emails = [$emails];
        } elseif (count($emails) === 0) {
            throw new InvalidArgumentException('The user emails parameter should be a single email or an array of emails');
        }

        return $this->delete('/user/emails', ['emails' => $emails]);
    }
}
