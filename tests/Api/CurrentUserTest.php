<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\CurrentUser;
use OwenVoke\Gitea\Api\CurrentUser\Emails;
use OwenVoke\Gitea\Api\CurrentUser\Notifications;
use OwenVoke\Gitea\Api\CurrentUser\PublicKeys;

beforeEach(fn () => $this->apiClass = CurrentUser::class);

it('should show the current user', function () {
    $expectedArray = ['id' => 1, 'username' => 'owenvoke'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/user')
        ->will($this->returnValue($expectedArray));

    expect($api->show())->toBe($expectedArray);
});

it('should get emails api object', function () {
    $api = $this->getApiMock();

    expect($api->emails())->toBeInstanceOf(Emails::class);
});

it('should get public keys api object', function () {
    $api = $this->getApiMock();

    expect($api->keys())->toBeInstanceOf(PublicKeys::class);
});

it('should get notifications api object', function () {
    $api = $this->getApiMock();

    expect($api->notifications())->toBeInstanceOf(Notifications::class);
});
