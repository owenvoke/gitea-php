<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Organization;

beforeEach(fn () => $this->apiClass = Organization::class);

it('should get all organisations', function () {
    $expectedArray = [['id' => 1, 'username' => 'TestOrg']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/orgs')
        ->willReturn($expectedArray);

    expect($api->all())->toBe($expectedArray);
});

it('should show an organisation', function () {
    $expectedArray = ['id' => 1, 'username' => 'TestOrg'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/orgs/TestOrg')
        ->willReturn($expectedArray);

    expect($api->show('TestOrg'))->toBe($expectedArray);
});

it('should update an organisation', function () {
    $expectedArray = ['id' => 1, 'username' => 'TestOrg'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('patch')
        ->with('/orgs/TestOrg', ['value' => 'toUpdate'])
        ->willReturn($expectedArray);

    expect($api->update('TestOrg', ['value' => 'toUpdate']))->toBe($expectedArray);
});

it('should get an organisations repositories', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/orgs/TestOrg/repos')
        ->willReturn($expectedArray);

    expect($api->repositories('TestOrg'))->toBe($expectedArray);
});
