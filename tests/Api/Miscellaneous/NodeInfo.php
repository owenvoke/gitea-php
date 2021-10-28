<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Miscellaneous\NodeInfo;

beforeEach(fn() => $this->apiClass = NodeInfo::class);

it('should show node info', function () {
    $expectedValue = [
        "version" => "2.1",
        "software" => [
            "name" => "gitea",
            "version" => "1.16.0+dev-434-g3fc465ba5",
            "repository" => "https://github.com/go-gitea/gitea.git",
            "homepage" => "https://gitea.io/",
        ],
        "protocols" => [
            "activitypub",
        ],
        "services" => [
            "inbound" => [
            ],
            "outbound" => [
            ],
        ],
        "openRegistrations" => true,
        "usage" => [
            "users" => [
            ],
        ],
        "metadata" => [
        ],
    ];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/nodeinfo')
        ->willReturn($expectedValue);

    expect($api->show())->toBe($expectedValue);
});
