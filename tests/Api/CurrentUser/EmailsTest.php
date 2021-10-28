<?php

use OwenVoke\Gitea\Api\CurrentUser\Emails;
use OwenVoke\Gitea\Exception\InvalidArgumentException;

beforeEach(fn () => $this->apiClass = Emails::class);

it('should get emails', function () {
    $expectedValue = [['email' => 'email@example.com', 'primary' => true, 'verified' => true]];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/user/emails')
        ->willReturn($expectedValue);

    expect($api->all())->toBe($expectedValue);
});

it('should add email', function () {
    $expectedValue = ['some value'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/user/emails', ['emails' => ['email@example.com']])
        ->willReturn($expectedValue);

    expect($api->add('email@example.com'))->toBe($expectedValue);
});

it('should add emails', function () {
    $expectedValue = ['some value'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/user/emails', ['emails' => ['email@example.com', 'email2@example.com']])
        ->willReturn($expectedValue);

    expect($api->add(['email@example.com', 'email2@example.com']))->toBe($expectedValue);
});

it('should not add emails when none are passed', function () {
    $api = $this->getApiMock();
    $api->expects($this->any())
        ->method('post');

    $api->add([]);
})->throws(InvalidArgumentException::class);

it('should remove email', function () {
    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('delete')
        ->with('/user/emails', ['emails' => ['email@example.com']])
        ->willReturn('');

    expect($api->remove('email@example.com'))->toBe('');
});

it('should remove emails', function () {
    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('delete')
        ->with('/user/emails', ['emails' => ['email@example.com', 'email2@example.com']])
        ->willReturn('');

    expect($api->remove(['email@example.com', 'email2@example.com']))->toBe('');
});

it('should not remove emails when none are passed', function () {
    $api = $this->getApiMock();
    $api->expects($this->any())
        ->method('delete');

    $api->remove([]);
})->throws(InvalidArgumentException::class);
