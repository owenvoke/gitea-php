<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\Organization;
use OwenVoke\Gitea\Api\Repo;
use OwenVoke\Gitea\Api\User;
use OwenVoke\Gitea\Client;

it('gets instances from the client', function () {
    $client = new Client();

    // Retrieves CurrentUser instance
    expect($client->currentUser())->toBeInstanceOf(CurrentUser::class);
    expect($client->current_user())->toBeInstanceOf(CurrentUser::class);
    expect($client->me())->toBeInstanceOf(CurrentUser::class);

    // Retrieves Organization instance
    expect($client->organization())->toBeInstanceOf(Organization::class);
    expect($client->organizations())->toBeInstanceOf(Organization::class);

    // Retrieves User instance
    expect($client->repo())->toBeInstanceOf(Repo::class);
    expect($client->repos())->toBeInstanceOf(Repo::class);
    expect($client->repository())->toBeInstanceOf(Repo::class);
    expect($client->repositories())->toBeInstanceOf(Repo::class);

    // Retrieves User instance
    expect($client->user())->toBeInstanceOf(User::class);
    expect($client->users())->toBeInstanceOf(User::class);
});

it('allows setting a custom url', function () {
    $client = new Client(null, null, 'https://gitea.test');
    expect($client->getEnterpriseUrl())->toBe('https://gitea.test');
});

it('allows setting a custom api version', function () {
    $client = new Client(null, 'v2');
    expect($client->getApiVersion())->toBe('v2');
});
