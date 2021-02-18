<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Miscellaneous\SigningKey;

beforeEach(fn () => $this->apiClass = SigningKey::class);

it('should show signing key', function () {
    $expectedValue = 'ABCDEFG';

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/signing-key.gpg')
        ->will($this->returnValue($expectedValue));

    expect($api->show())->toBe($expectedValue);
});
