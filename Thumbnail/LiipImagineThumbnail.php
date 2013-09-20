<?php

/**
 * Fix some LiipImagineThumbnail errors
 *
 * @author     Blaise de Carné <blaise@concretis.com>
 */

namespace Veilhan\Bundle\MediaBundle\Thumbnail;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\Routing\RouterInterface;
use Sonata\MediaBundle\Thumbnail\LiipImagineThumbnail as BaseLiipImagineThumbnail;

class LiipImagineThumbnail extends BaseLiipImagineThumbnail
{
    /**
     * {@inheritdoc}
     */
    public function generatePublicUrl(MediaProviderInterface $provider, MediaInterface $media, $format)
    {
        if ($format == 'reference') {
            $path = $provider->getReferenceImage($media);
        } else {
            $path = $this->router->generate(
                sprintf('_imagine_%s', $format),
                array('path' => sprintf('%s/%s_%s.jpg', $provider->generatePath($media), $media->getId(), $format))
            );
            $path = ltrim($path, '/');
        }
        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(MediaProviderInterface $provider, MediaInterface $media)
    {
        // feature not available
        return;
    }
}
