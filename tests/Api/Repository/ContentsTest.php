<?php

use OwenVoke\Gitea\Api\Repository\Contents;

beforeEach(fn () => $this->apiClass = Contents::class);

it('should get metadata of all the entries of the root dir for a repository', function () {
    $expectedValue = [
        [
            '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
            'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
            'target' => '', 'type' => '', 'url' => ''
        ]
    ];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/contents')
        ->willReturn($expectedValue);

    expect($api->all('owenvoke', 'gitea-php'))->toBe($expectedValue);
});

it('should get metadata of all the entries of the root dir for a repository by the ref', function () {
    $expectedValue = [
        [
            '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
            'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
            'target' => '', 'type' => '', 'url' => ''
        ]
    ];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/contents?ref=main')
        ->willReturn($expectedValue);

    expect($api->all('owenvoke', 'gitea-php', 'main'))->toBe($expectedValue);
});
