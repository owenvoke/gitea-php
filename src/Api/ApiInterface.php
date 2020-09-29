<?php

declare(strict_types=1);

namespace OwenVoke\Gitea\Api;

interface ApiInterface
{
    public function getPerPage();

    public function setPerPage($perPage);
}
