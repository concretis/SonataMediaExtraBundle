<?php
/**
 * @author     Blaise de Carné <blaise@concretis.com>
 */
namespace Concretis\SonataMediaExtraBundle\Controller;

use Sonata\MediaBundle\Controller\MediaController as BaseMediaController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MediaController extends BaseMediaController {

    /**
     * {@inheritdoc}
     */
    public function liipImagineFilterAction($path, $filter)
    {
        if (!preg_match('@([^/]*)/(.*)/([0-9]*)_([a-z_A-Z]*).jpg@', $path, $matches)) {
            throw new NotFoundHttpException();
        }

        $targetPath = $this->get('liip_imagine.cache.manager')->resolve($this->get('request'), $path, $filter);

        if ($targetPath instanceof Response) {
            return $targetPath;
        }

        // get the file
        $media = $this->getMedia($matches[3]);
        if (!$media) {
            throw new NotFoundHttpException();
        }

        $provider = $this->getProvider($media);
        $file     = $provider->getReferenceFile($media);

        // load the file content from the abstrated file system
        $tmpFile = sprintf('%s.%s', tempnam(sys_get_temp_dir(), 'sonata_media_liip_imagine'), $media->getExtension());
        file_put_contents($tmpFile, $file->getContent());

        if($provider->getName() == 'sonata.media.provider.pdf') {
            // specific code for pdf preview
            $im = new \Imagick();
            $im->setResolution(200, 200);
            $im->readImage($tmpFile.'[0]');
            $im->setCompressionQuality(90);
            $image  = new \Imagine\Imagick\Image($im);
        } else {
            $image = $this->get('liip_imagine')->open($tmpFile);
        }

        $response = $this->get('liip_imagine.filter.manager')->get($this->get('request'), $filter, $image, $path);

        if ($targetPath) {
            $response = $this->get('liip_imagine.cache.manager')->store($response, $targetPath, $filter);
        }

        return $response;
    }
}
