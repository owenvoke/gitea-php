<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

use OwenVoke\Gitea\Api\Repository\Commits;
use OwenVoke\Gitea\Api\Repository\Contents;
use OwenVoke\Gitea\Api\Repository\Stargazers;

class Repo extends AbstractApi
{
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
        string|null $organization = null,
        string|null $license = null,
        string|null $readme = null,
        string|null $gitignores = null,
        string|null $issueLabels = null,
        bool $autoInit = false
    ): array {
        $path = $organization !== null ? "/orgs/{$organization}/repos" : '/user/repos';

        $parameters = [
            'name' => $name,
            'description' => $description,
            'homepage' => $homepage,
            'private' => ! $public,
            'license' => $license,
            'readme' => $readme,
            'gitignores' => $gitignores,
            'issue_labels' => $issueLabels,
            'auto_init' => $autoInit,
        ];

        return $this->post($path, $parameters);
    }

    public function generate(
        string $templateOwner,
        string $templateName,
        string $name,
        string $organization,
        string $description = '',
        bool $public = true,
        bool $avatar = true,
        bool $labels = true,
        bool $gitContent = true,
        bool $gitHooks = true,
        bool $protectedBranch = true,
        bool $topics = true,
        bool $webhooks = true,
        string|null $defaultBranch = null
    ): array {
        $path = "/repos/{$templateOwner}/{$templateName}/generate";

        $parameters = [
            'name' => $name,
            'owner' => $organization,
            'private' => ! $public,
            'description' => $description,
            'avatar' => $avatar,
            'default_branch' => $defaultBranch,
            'git_content' => $gitContent,
            'git_hooks' => $gitHooks,
            'labels' => $labels,
            'protected_branch' => $protectedBranch,
            'topics' => $topics,
            'webhooks' => $webhooks,
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

    public function branches(string $username, string $repository, string|null $branch = null): array
    {
        $url = sprintf('/repos/%s/%s/branches', rawurlencode($username), rawurlencode($repository));
        if ($branch !== null) {
            $url .= '/'.rawurlencode($branch);
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

    public function issues(): Issue
    {
        return new Issue($this->getClient());
    }

    public function commits(): Commits
    {
        return new Commits($this->getClient());
    }

    public function contents(): Contents
    {
        return new Contents($this->getClient());
    }

    public function stargazers(): Stargazers
    {
        return new Stargazers($this->getClient());
    }
}
