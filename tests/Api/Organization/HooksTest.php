<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Organization\Hooks;
use OwenVoke\Gitea\Exception\MissingArgumentException;

beforeEach(fn () => $this->apiClass = Hooks::class);

it('should get all hooks for an organization', function () {
    $expectedValue = [['name' => 'hook']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/orgs/TestOrg/hooks')
        ->willReturn($expectedValue);

    expect($api->all('TestOrg'))->toBe($expectedValue);
});

it('should get a hook by its id', function () {
    $expectedValue = ['name' => 'hook'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/orgs/TestOrg/hooks/123')
        ->willReturn($expectedValue);

    expect($api->show('TestOrg', 123))->toBe($expectedValue);
});

it('should remove a hook by its id', function () {
    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('delete')
        ->with('/orgs/TestOrg/hooks/123')
        ->will($this->returnValue(''));

    expect($api->remove('TestOrg', 123))->toBe('');
});

it('should not create a hook without a config', function () {
    $data = ['name' => 'test'];

    $api = $this->getApiMock();

    $api->expects($this->never())
        ->method('post');

    $api->create('TestOrg', $data);
})->throws(MissingArgumentException::class);

it('should create a hook', function () {
    $expectedValue = ['hook' => 'hook-name'];
    $data = ['name' => 'test', 'config' => 'someconfig'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('post')
        ->with('/orgs/TestOrg/hooks')
        ->willReturn($expectedValue);

    expect($api->create('TestOrg', $data))->toBe($expectedValue);
});

it('should not update a hook without a config', function () {
    $data = [];

    $api = $this->getApiMock();

    $api->expects($this->never())
        ->method('patch');

    $api->update('TestOrg', 123, $data);
})->throws(MissingArgumentException::class);

it('should update a hook', function () {
    $expectedValue = ['hook' => 'hook-name'];
    $data = ['name' => 'test', 'config' => 'someconfig'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('patch')
        ->with('/orgs/TestOrg/hooks/123', $data)
        ->willReturn($expectedValue);

    expect($api->update('TestOrg', 123, $data))->toBe($expectedValue);
});
