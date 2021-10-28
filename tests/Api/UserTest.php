<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\User;

beforeEach(fn () => $this->apiClass = User::class);

it('should show a user', function () {
    $expectedArray = ['id' => 1, 'username' => 'owenvoke'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke')
        ->willReturn($expectedArray);

    expect($api->show('owenvoke'))->toBe($expectedArray);
});

it('should get users that a user follows', function () {
    $expectedArray = [['id' => 1, 'username' => 'other-user']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/following')
        ->willReturn($expectedArray);

    expect($api->following('owenvoke'))->toBe($expectedArray);
});

it('should get users that are following a user', function () {
    $expectedArray = [['id' => 1, 'username' => 'other-user']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/followers')
        ->willReturn($expectedArray);

    expect($api->followers('owenvoke'))->toBe($expectedArray);
});

it('should get repositories that are starred by a user', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/starred')
        ->willReturn($expectedArray);

    expect($api->starred('owenvoke'))->toBe($expectedArray);
});

it('should get repositories that a user is subscribed to', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/subscriptions')
        ->willReturn($expectedArray);

    expect($api->subscriptions('owenvoke'))->toBe($expectedArray);
});

it('should get repositories for a user', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/repos')
        ->willReturn($expectedArray);

    expect($api->repositories('owenvoke'))->toBe($expectedArray);
});

it('should get repositories for the currently authenticated user', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/user/repos', [])
        ->willReturn($expectedArray);

    expect($api->myRepositories())->toBe($expectedArray);
});

it('should get public keys for a user', function () {
    $expectedArray = [['id' => 1, 'fingerprint' => 'ssh12345']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/keys')
        ->willReturn($expectedArray);

    expect($api->keys('owenvoke'))->toBe($expectedArray);
});

it('should get gpg keys for a user', function () {
    $expectedArray = [['id' => 1, 'key_id' => 'gpg12345']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/gpg_keys')
        ->willReturn($expectedArray);

    expect($api->gpgKeys('owenvoke'))->toBe($expectedArray);
});

it('should get heatmap data for a user', function () {
    $expectedArray = [['contributions' => 1, 'timestamp' => 0]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/users/owenvoke/heatmap')
        ->willReturn($expectedArray);

    expect($api->heatmap('owenvoke'))->toBe($expectedArray);
});
