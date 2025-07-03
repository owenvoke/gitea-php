<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Repository\Stargazers;

beforeEach(fn () => $this->apiClass = Stargazers::class);

it('should get all stagazers for a repository', function () {
    $expectedValue = [['id' => 1, 'username' => 'owenvoke']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/stargazers')
        ->willReturn($expectedValue);

    expect($api->all('owenvoke', 'gitea-php'))->toBe($expectedValue);
});
