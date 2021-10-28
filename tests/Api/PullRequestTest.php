<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\PullRequest;

beforeEach(fn () => $this->apiClass = PullRequest::class);

it('should get all pull requests', function () {
    $expectedArray = ['pr1', 'pr2'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/pulls')
        ->willReturn($expectedArray);

    expect($api->all('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should show pull request by id', function () {
    $expectedArray = ['id' => 1, 'title' => 'pr number 1'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/pulls/1')
        ->willReturn($expectedArray);

    expect($api->show('owenvoke', 'gitea-php', 1))->toBe($expectedArray);
});

it('should show pull request diff by id', function () {
    $expectedValue = '+ abcd';

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/pulls/1.diff')
        ->willReturn($expectedValue);

    expect($api->showDiff('owenvoke', 'gitea-php', 1))->toBe($expectedValue);
});

it('should show pull request patch by id', function () {
    $expectedValue = '+ abcd';

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/pulls/1.patch')
        ->willReturn($expectedValue);

    expect($api->showPatch('owenvoke', 'gitea-php', 1))->toBe($expectedValue);
});

it('should create a pull request with all parameters', function () {
    $expectedArray = ['id' => 1, 'title' => 'pr number 1'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/pulls', [
            'title' => 'pr number 1',
            'body' => 'pr body',
            'base' => 'master',
            'head' => 'feature/pr-1',
        ])
        ->willReturn($expectedArray);

    expect($api->create('owenvoke', 'gitea-php', [
        'title' => 'pr number 1',
        'body' => 'pr body',
        'base' => 'master',
        'head' => 'feature/pr-1',
    ]))->toBe($expectedArray);
});

it('should update a pull request', function () {
    $expectedArray = ['id' => 1, 'title' => 'test'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('patch')
        ->with('/repos/owenvoke/gitea-php/pulls/1')
        ->willReturn($expectedArray);

    expect($api->update('owenvoke', 'gitea-php', 1, ['title' => 'test']))->toBe($expectedArray);
});
