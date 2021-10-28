<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Settings;

beforeEach(fn () => $this->apiClass = Settings::class);

it('should get the API settings for the instance', function () {
    $expectedArray = ['default_git_trees_per_page' => 0];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/settings/api')
        ->willReturn($expectedArray);

    expect($api->api())->toBe($expectedArray);
});

it('should get the attachment settings for the instance', function () {
    $expectedArray = ['enabled' => true];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/settings/attachment')
        ->willReturn($expectedArray);

    expect($api->attachment())->toBe($expectedArray);
});

it('should get the repository settings for the instance', function () {
    $expectedArray = ['http_git_disabled' => true];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/settings/repository')
        ->willReturn($expectedArray);

    expect($api->repository())->toBe($expectedArray);
});

it('should get the UI settings for the instance', function () {
    $expectedArray = ['default_theme' => 'gitea'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/settings/ui')
        ->willReturn($expectedArray);

    expect($api->ui())->toBe($expectedArray);
});
