<?php

use OwenVoke\Gitea\Api\Repository\Contents;
use OwenVoke\Gitea\Exception\MissingArgumentException;

beforeEach(fn () => $this->apiClass = Contents::class);

it('should get files of the root dir for a repository', function () {
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

it('should get files of the root dir for a repository by the ref', function () {
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

it('should modify files in repository without using the files option', function () {
    $data = [];

    $api = $this->getApiMock();
    $api->expects($this->never())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/contents', $data);

    $api->bulkModify('owenvoke', 'gitea-php', $data);
})->throws(MissingArgumentException::class);

it('should modify files in repository using option files', function () {
    $expectedValue = ['files' => []];
    $data = ['files' => []];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/contents', $data)
        ->willReturn($expectedValue);

    expect($api->bulkModify('owenvoke', 'gitea-php', $data))->toBe($expectedValue);
});

it('should get file for a repository', function () {
    $expectedValue = [
        '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
        'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
        'target' => '', 'type' => '', 'url' => ''
    ];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt')
        ->willReturn($expectedValue);

    expect($api->show('owenvoke', 'gitea-php', 'content.txt'))->toBe($expectedValue);
});

it('should get file for a repository by the ref', function () {
    $expectedValue = [
        '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
        'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
        'target' => '', 'type' => '', 'url' => ''
    ];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt?ref=main')
        ->willReturn($expectedValue);

    expect($api->show('owenvoke', 'gitea-php', 'content.txt', 'main'))->toBe($expectedValue);
});

it('should update a file in the repository without using the content option', function () {
    $data = [];

    $api = $this->getApiMock();
    $api->expects($this->never())
        ->method('put')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt', $data);

    $api->update('owenvoke', 'gitea-php', 'content.txt', $data);
})->throws(MissingArgumentException::class);

it('should update a file in the repository without using the sha option', function () {
    $data = ['content' => ''];

    $api = $this->getApiMock();
    $api->expects($this->never())
        ->method('put')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt', $data);

    $api->update('owenvoke', 'gitea-php', 'content.txt', $data);
})->throws(MissingArgumentException::class);

it('should update a file in the repository', function () {
    $expectedValue = [
        'content' => [
            '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
            'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
            'target' => '', 'type' => '', 'url' => ''
        ]
    ];
    $data = ['content' => '', 'sha' => ''];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('put')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt')
        ->willReturn($expectedValue);

    expect($api->update('owenvoke', 'gitea-php', 'content.txt', $data))->toBe($expectedValue);
});

it('should create a file in the repository without using the content option', function () {
    $data = [];

    $api = $this->getApiMock();
    $api->expects($this->never())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt', $data);

    $api->create('owenvoke', 'gitea-php', 'content.txt', $data);
})->throws(MissingArgumentException::class);

it('should create a file in the repository', function () {
    $expectedValue = [
        'content' => [
            '_links' => [], 'content' => '', 'download_url' => '', 'encoding' => '', 'git_url' => '', 'html_url' => '',
            'last_commit_sha' => '', 'name' => '', 'path' => '', 'sha' => '', 'size' => 0, 'submodule_git_url' => '',
            'target' => '', 'type' => '', 'url' => ''
        ]
    ];
    $data = ['content' => ''];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt')
        ->willReturn($expectedValue);

    expect($api->create('owenvoke', 'gitea-php', 'content.txt', $data))->toBe($expectedValue);
});

it('should remove a file in the repository without using the sha option', function () {
    $data = [];

    $api = $this->getApiMock();
    $api->expects($this->never())
        ->method('delete')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt', $data);

    $api->remove('owenvoke', 'gitea-php', 'content.txt', $data);
})->throws(MissingArgumentException::class);

it('should remove a file in the repository', function () {
    $expectedValue = [
        'content' => null
    ];
    $data = ['sha' => ''];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('delete')
        ->with('/repos/owenvoke/gitea-php/contents/content.txt')
        ->willReturn($expectedValue);

    expect($api->remove('owenvoke', 'gitea-php', 'content.txt', $data))->toBe($expectedValue);
});
