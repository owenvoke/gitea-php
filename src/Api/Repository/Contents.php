<?php

namespace OwenVoke\Gitea\Api\Repository;

use OwenVoke\Gitea\Api\AbstractApi;

class Contents extends AbstractApi
{
    public function all(string $owner, string $repository, string $ref = ''): array
    {
        $format = '/repos/%s/%s/contents';
        if (!empty($ref)) {
            $format = '/repos/%s/%s/contents?ref=%s';
        }

        return $this->get(sprintf($format, rawurlencode($owner), rawurlencode($repository), rawurlencode($ref)));
    }
}
