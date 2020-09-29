<?php

namespace OwenVoke\Gitea\Api;

use OwenVoke\Gitea\Api\Repository\Commits;
use OwenVoke\Gitea\Api\Repository\Stargazers;

class Repo extends AbstractApi
{
    use AcceptHeaderTrait;

    public function show(string $username, string $repository): array
    {
        return $this->get(sprintf('/repos/%s/%s', rawurlencode($username), rawurlencode($repository)));
    }

    public function showById(int $id): array
    {
        return $this->get("/repositories/{$id}");
    }

    public function create(
        string $name,
        string $description = '',
        string $homepage = '',
        bool $public = true,
        ?string $organization = null,
        ?string $license = null,
        ?string $readme = null,
        ?string $gitignores = null,
        ?string $issueLabels = null,
        bool $autoInit = false
    ): array {
        $path = $organization !== null ? "/orgs/{$organization}/repos" : '/user/repos';

        $parameters = [
            'name' => $name,
            'description' => $description,
            'homepage' => $homepage,
            'private' => !$public,
            'license' => $license,
            'readme' => $readme,
            'gitignores' => $gitignores,
            'issue_labels' => $issueLabels,
            'auto_init' => $autoInit,
        ];

        return $this->post($path, $parameters);
    }

    public function update(string $username, string $repository, array $values): array
    {
        return $this->patch(sprintf('/repos/%s/%s', rawurlencode($username), rawurlencode($repository)), $values);
    }

    public function remove(string $username, string $repository)
    {
        return $this->delete(sprintf('/repos/%s/%s', rawurlencode($username), rawurlencode($repository)));
    }

    public function branches(string $username, string $repository, ?string $branch = null): array
    {
        $url = sprintf('/repos/%s/%s/branches', rawurlencode($username), rawurlencode($repository));
        if ($branch !== null) {
            $url .= '/' . rawurlencode($branch);
        }

        return $this->get($url);
    }

    public function collaborators(string $username, string $repository): array
    {
        return $this->get(sprintf('/repos/%s/%s/collaborators', rawurlencode($username), rawurlencode($repository)));
    }

    public function tags(string $username, string $repository, int $page = 1): array
    {
        return $this->get(sprintf('/repos/%s/%s/tags', rawurlencode($username), rawurlencode($repository)), [
            'page' => $page,
        ]);
    }

    public function subscribers(string $username, string $repository, int $page = 1): array
    {
        return $this->get(sprintf('/repos/%s/%s/subscribers', rawurlencode($username), rawurlencode($repository)), [
            'page' => $page,
        ]);
    }

    public function milestones(string $username, string $repository, array $parameters = []): array
    {
        return $this->get(sprintf('/repos/%s/%s/milestones', rawurlencode($username), rawurlencode($repository)), $parameters);
    }

    public function topics(string $username, string $repository, int $page = 1): array
    {
        return $this->get(sprintf('/repos/%s/%s/topics', rawurlencode($username), rawurlencode($repository)), [
            'page' => $page,
        ]);
    }

    public function replaceTopics(string $username, string $repository, array $topics)
    {
        return $this->put(sprintf('/repos/%s/%s/topics', rawurlencode($username), rawurlencode($repository)), [
            'topics' => $topics,
        ]);
    }

    public function transfer(string $username, string $repository, string $newOwner, array $teamId = [])
    {
        return $this->post(sprintf('/repos/%s/%s/transfer', rawurlencode($username), rawurlencode($repository)), [
            'new_owner' => $newOwner,
            'team_ids' => $teamId,
        ]);
    }

    public function commits(): Commits
    {
        return new Commits($this->client);
    }

    public function stargazers(): Stargazers
    {
        return new Stargazers($this->client);
    }
}
