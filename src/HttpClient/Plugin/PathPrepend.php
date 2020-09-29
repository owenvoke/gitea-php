<?php

namespace OwenVoke\Gitea\HttpClient\Plugin;

use Http\Promise\Promise;
use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;
use Http\Client\Common\Plugin\VersionBridgePlugin;

/**
 * Prepend the URI with a string.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class PathPrepend implements Plugin
{
    use VersionBridgePlugin;

    private string $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function doHandleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $currentPath = $request->getUri()->getPath();
        if (strpos($currentPath, $this->path) !== 0) {
            $uri = $request->getUri()->withPath($this->path . $currentPath);
            $request = $request->withUri($uri);
        }

        return $next($request);
    }
}
