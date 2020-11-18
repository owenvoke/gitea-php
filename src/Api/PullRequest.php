<?php

namespace OwenVoke\Gitea\Api;

use OwenVoke\Gitea\Exception\MissingArgumentException;

class PullRequest extends AbstractApi
{
    public function all(string $username, string $repository, array $params = []): array
    {
        return $this->get(sprintf('/repos/%s/%s/pulls', rawurlencode($username), rawurlencode($repository)), $params);
    }

    public function show(string $username, string $repository, int $id): array
    {
        return $this->get(sprintf('/repos/%s/%s/pulls/%s', rawurlencode($username), rawurlencode($repository), $id));
    }

    public function showDiff(string $username, string $repository, int $id): string
    {
        return $this->get(sprintf('/repos/%s/%s/pulls/%s.diff', rawurlencode($username), rawurlencode($repository), $id));
    }

    public function showPatch(string $username, string $repository, int $id): string
    {
        return $this->get(sprintf('/repos/%s/%s/pulls/%s.patch', rawurlencode($username), rawurlencode($repository), $id));
    }

    public function create(string $username, string $repository, array $params): array
    {
        if (! isset($params['title'], $params['body'])) {
            throw new MissingArgumentException(['title', 'body']);
        }

        if (! isset($params['base'], $params['head'])) {
            throw new MissingArgumentException(['base', 'head']);
        }

        return $this->post(sprintf('/repos/%s/%s/pulls', rawurlencode($username), rawurlencode($repository)), $params);
    }

    public function update(string $username, string $repository, int $id, array $params)
    {
        if (isset($params['state']) && ! in_array($params['state'], ['open', 'closed'])) {
            $params['state'] = 'open';
        }

        return $this->patch(sprintf('/repos/%s/%s/pulls/%s', rawurlencode($username), rawurlencode($repository), $id), $params);
    }
}
