<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Miscellaneous\Markdown;

beforeEach(fn () => $this->apiClass = Markdown::class);

it('should render markdown', function () {
    $input = 'Hello world github/linguist#1 **cool**, and #1!';

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/markdown', ['text' => $input, 'mode' => 'markdown'])
        ->willReturn('');

    $api->render($input);
});

it('should set the mode to markdown when invalid mode is passed', function () {
    $input = 'Hello world github/linguist#1 **cool**, and #1!';

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/markdown', ['text' => $input, 'mode' => 'markdown'])
        ->willReturn('');

    $api->render($input, 'abc');
});
