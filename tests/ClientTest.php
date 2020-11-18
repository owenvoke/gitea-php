<?php

declare(strict_types=1);

use OwenVoke\Gitea\Client;

it('allows setting a custom url', function () {
    $client = new Client(null, null, 'https://gitea.test');
    expect($client->getEnterpriseUrl())->toBe('https://gitea.test');
});

it('allows setting a custom api version', function () {
    $client = new Client(null, 'v2');
    expect($client->getApiVersion())->toBe('v2');
});
