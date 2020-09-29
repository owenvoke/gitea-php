<?php

namespace OwenVoke\Gitea\Api\Miscellaneous;

use OwenVoke\Gitea\Api\AbstractApi;

class Markdown extends AbstractApi
{
    public function render($text, $mode = 'markdown', $context = null): string
    {
        if (! in_array($mode, ['gfm', 'markdown'])) {
            $mode = 'markdown';
        }

        $params = [
            'text' => $text,
            'mode' => $mode,
        ];

        if ($context !== null && $mode === 'gfm') {
            $params['context'] = $context;
        }

        return $this->post('/markdown', $params);
    }
}
