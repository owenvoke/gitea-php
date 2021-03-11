<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Issue;

beforeEach(fn () => $this->apiClass = Issue::class);

it('should get all issues', function () {
    $expectedArray = ['issue1', 'issue2'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/issues')
        ->will($this->returnValue($expectedArray));

    expect($api->all('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should show issue by id', function () {
    $expectedArray = ['title' => 'Test'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/issues/1')
        ->will($this->returnValue($expectedArray));

    expect($api->show('owenvoke', 'gitea-php', 1))->toBe($expectedArray);
});

it('should create an issue only using its title', function () {
    $expectedArray = ['title' => 'Test'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/issues', $expectedArray)
        ->will($this->returnValue($expectedArray));

    expect($api->create('owenvoke', 'gitea-php', $expectedArray))->toBe($expectedArray);
});
