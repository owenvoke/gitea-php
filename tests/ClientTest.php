<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Admin;
use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\Issue;
use OwenVoke\Gitea\Api\Miscellaneous\Markdown;
use OwenVoke\Gitea\Api\Miscellaneous\SigningKey;
use OwenVoke\Gitea\Api\Miscellaneous\Version;
use OwenVoke\Gitea\Api\Organization;
use OwenVoke\Gitea\Api\PullRequest;
use OwenVoke\Gitea\Api\Repo;
use OwenVoke\Gitea\Api\Settings;
use OwenVoke\Gitea\Api\User;
use OwenVoke\Gitea\Client;

it('gets instances from the client', function () {
    $client = new Client();

    // Retrieves Admin instance
    expect($client->admin())->toBeInstanceOf(Admin::class);

    // Retrieves CurrentUser instance
    expect($client->currentUser())->toBeInstanceOf(CurrentUser::class);
    expect($client->current_user())->toBeInstanceOf(CurrentUser::class);
    expect($client->me())->toBeInstanceOf(CurrentUser::class);

    // Retrieves Issue instance
    expect($client->issue())->toBeInstanceOf(Issue::class);
    expect($client->issues())->toBeInstanceOf(Issue::class);

    // Retrieves Markdown instance
    expect($client->markdown())->toBeInstanceOf(Markdown::class);

    // Retrieves Organization instance
    expect($client->organization())->toBeInstanceOf(Organization::class);
    expect($client->organizations())->toBeInstanceOf(Organization::class);

    // Retrieves PullRequest instance
    expect($client->pr())->toBeInstanceOf(PullRequest::class);
    expect($client->pullRequest())->toBeInstanceOf(PullRequest::class);
    expect($client->pullRequests())->toBeInstanceOf(PullRequest::class);

    // Retrieves Repo instance
    expect($client->repo())->toBeInstanceOf(Repo::class);
    expect($client->repos())->toBeInstanceOf(Repo::class);
    expect($client->repository())->toBeInstanceOf(Repo::class);
    expect($client->repositories())->toBeInstanceOf(Repo::class);

    // Retrieves Settings instance
    expect($client->settings())->toBeInstanceOf(Settings::class);

    // Retrieves SigningKey instance
    expect($client->signingKey())->toBeInstanceOf(SigningKey::class);

    // Retrieves User instance
    expect($client->user())->toBeInstanceOf(User::class);
    expect($client->users())->toBeInstanceOf(User::class);

    // Retrieves Version instance
    expect($client->version())->toBeInstanceOf(Version::class);
});

it('allows setting a custom url', function () {
    $client = new Client(null, null, 'https://gitea.test');
    expect($client->getEnterpriseUrl())->toBe('https://gitea.test');
});

it('allows setting a custom api version', function () {
    $client = new Client(null, 'v2');
    expect($client->getApiVersion())->toBe('v2');
});
