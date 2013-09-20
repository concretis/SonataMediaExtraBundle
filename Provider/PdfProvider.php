<?php
/**
 * @author     Blaise de Carné <blaise@concretis.com>
 */
namespace Concretis\SonataMediaExtraBundle\Provider;

use Gaufrette\Filesystem;
use Imagine\Image\ImagineInterface;
use Sonata\MediaBundle\CDN\CDNInterface;
use Sonata\MediaBundle\Generator\GeneratorInterface;
use Sonata\MediaBundle\Metadata\MetadataBuilderInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\BaseProvider;
use Sonata\MediaBundle\Provider\FileProvider;
use Sonata\MediaBundle\Thumbnail\ThumbnailInterface;
use Symfony\Component\Form\FormBuilder;

class PdfProvider extends FileProvider
{
    protected $imagineAdapter;

    /**
     * @param string                                                $name
     * @param \Gaufrette\Filesystem                                 $filesystem
     * @param \Sonata\MediaBundle\CDN\CDNInterface                  $cdn
     * @param \Sonata\MediaBundle\Generator\GeneratorInterface      $pathGenerator
     * @param \Sonata\MediaBundle\Thumbnail\ThumbnailInterface      $thumbnail
     * @param array                                                 $allowedExtensions
     * @param array                                                 $allowedMimeTypes
     * @param \Imagine\Image\ImagineInterface                       $adapter
     * @param \Sonata\MediaBundle\Metadata\MetadataBuilderInterface $metadata
     */
    public function __construct($name, Filesystem $filesystem, CDNInterface $cdn, GeneratorInterface $pathGenerator, ThumbnailInterface $thumbnail, array $allowedExtensions = array(), array $allowedMimeTypes = array(), ImagineInterface $adapter, MetadataBuilderInterface $metadata = null)
    {
        parent::__construct($name, $filesystem, $cdn, $pathGenerator, $thumbnail, $allowedExtensions, $allowedMimeTypes, $metadata);
        $this->imagineAdapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePublicUrl(MediaInterface $media, $format)
    {
        if ($format == 'reference') {
            $path = $this->getCdn()->getPath($this->getReferenceImage($media), $media->getCdnIsFlushable());
        } else {
            $path = $this->thumbnail->generatePublicUrl($this, $media, $format);
        }
        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePrivateUrl(MediaInterface $media, $format)
    {
        return $this->thumbnail->generatePrivateUrl($this, $media, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function getHelperProperties(MediaInterface $media, $format, $options = array())
    {
        $settings = $this->getFormat($format);

        if (isset($options['width']))
            $settings['width'] = $options['width'];

        if (isset($options['height']))
            $settings['height'] = $options['height'];

        $src = $this->getCdnPath($this->getReferenceImage($media), true);

        return array_merge(array(
            'alt'      => $media->getName(),
            'title'    => $media->getName(),
            'src'      => $src,
            'width'    => $settings['width'],
            'height'   => $settings['height']
        ), $options);
    }
}
