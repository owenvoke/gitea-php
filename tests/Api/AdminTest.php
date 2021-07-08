<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Admin;

beforeEach(fn () => $this->apiClass = Admin::class);

it('should show a list of organizations', function () {
    $expectedArray = ['id' => 1, 'username' => 'test'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/admin/orgs')
        ->will($this->returnValue($expectedArray));

    expect($api->organizations())->toBe($expectedArray);
});

it('should show a list of users', function () {
    $expectedArray = ['id' => 1, 'username' => 'owenvoke'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/admin/users')
        ->will($this->returnValue($expectedArray));

    expect($api->users())->toBe($expectedArray);
});

it('should show a list of unadopted repositories', function () {
    $expectedArray = ['test-1', 'test-2'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/admin/unadopted')
        ->will($this->returnValue($expectedArray));

    expect($api->unadopted())->toBe($expectedArray);
});

it('should show a list of cron tasks', function () {
    $expectedArray = ['name' => 'Test', 'exec_times' => 25];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/admin/cron')
        ->will($this->returnValue($expectedArray));

    expect($api->cron())->toBe($expectedArray);
});
