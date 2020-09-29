<?php

use OwenVoke\Gitea\Api\Repository\Commits;

beforeEach(fn () => $this->apiClass = Commits::class);

it('should get all commits for a repository', function () {
    $expectedValue = [['commit' => [], 'comitter' => []]];
    $data = ['sha' => 'v3'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/commits', $data)
        ->will($this->returnValue($expectedValue));

    expect($api->all('owenvoke', 'gitea-php', $data))->toBe($expectedValue);
});

it('should get a commit for a repository by its hash', function () {
    $expectedValue = [['sha' => '123', 'comitter' => []]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/git/commits/123')
        ->will($this->returnValue($expectedValue));

    expect($api->show('owenvoke', 'gitea-php', '123'))->toBe($expectedValue);
});
