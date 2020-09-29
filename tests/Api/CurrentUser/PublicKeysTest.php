<?php

use OwenVoke\Gitea\Api\CurrentUser\PublicKeys;

beforeEach(fn () => $this->apiClass = PublicKeys::class);

it('should get public keys', function () {
    $expectedValue = ['id' => 1, 'key' => 'blah', 'title' => 'My Key'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/user/keys')
        ->will($this->returnValue($expectedValue));

    expect($api->all())->toBe($expectedValue);
});

it('should create key', function () {
    $expectedValue = ['id' => 1, 'title' => '', 'key' => '', 'read_only' => true];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/user/keys', ['title' => 'My Key', 'key' => 'blah', 'read_only' => true])
        ->will($this->returnValue($expectedValue));

    expect($api->create(['title' => 'My Key', 'key' => 'blah', 'read_only' => true]))->toBe($expectedValue);
});

it('should remove key', function () {
    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('delete')
        ->with('/user/keys/1')
        ->will($this->returnValue(''));

    expect($api->remove(1))->toBe('');
});
