<?php

namespace Concretis\SonataMediaExtraBundle\CDN;
use Sonata\MediaBundle\CDN\Server as BaseServer;

/**
 * CDN Server to use with LiipImagineThumbnail
 * @package Concretis\MediaExtraBundle\CDN
 */
class Server extends BaseServer
{
    /**
     * {@inheritDoc}
     */
    public function getPath($relativePath, $isFlushable)
    {
        if($relativePath[0] == "/") {
            return $relativePath;
        } else {
            return sprintf('%s/%s', $this->path, $relativePath);
        }
    }
}
