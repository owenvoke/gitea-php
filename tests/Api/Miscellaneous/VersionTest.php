<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Miscellaneous\Version;

beforeEach(fn () => $this->apiClass = Version::class);

it('should show version', function () {
    $expectedArray = ['version' => '1.0.0'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/version')
        ->willReturn($expectedArray);

    expect($api->show())->toBe($expectedArray);
});
