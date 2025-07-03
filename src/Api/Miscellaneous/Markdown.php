<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api\Miscellaneous;

use OwenVoke\Gitea\Api\AbstractApi;

class Markdown extends AbstractApi
{
    public const MARKDOWN_MODE_DEFAULT = 'markdown';

    public const MARKDOWN_MODE_GFM = 'gfm';

    public function render(string $text, string $mode = self::MARKDOWN_MODE_DEFAULT, string|null $context = null): string
    {
        if (! in_array($mode, [self::MARKDOWN_MODE_DEFAULT, self::MARKDOWN_MODE_GFM])) {
            $mode = self::MARKDOWN_MODE_DEFAULT;
        }

        $params = [
            'text' => $text,
            'mode' => $mode,
        ];

        if ($context !== null && $mode === self::MARKDOWN_MODE_GFM) {
            $params['context'] = $context;
        }

        return $this->post('/markdown', $params, [
            'Accept' => 'text/html',
        ]);
    }
}
