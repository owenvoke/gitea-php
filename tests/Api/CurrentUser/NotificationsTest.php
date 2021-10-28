<?php

use OwenVoke\Gitea\Api\CurrentUser\Notifications;

beforeEach(fn () => $this->apiClass = Notifications::class);

it('should get notifications', function () {
    $expectedValue = [['id' => 1, 'pinned' => false]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/notifications')
        ->willReturn($expectedValue);

    expect($api->all())->toBe($expectedValue);
});
