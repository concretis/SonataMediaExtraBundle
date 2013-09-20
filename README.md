SonataMediaExtraBundle
======================

Basic PDF provider for SonataMediaExtraBundle.


# Installation

Just install the bundle like any other.

# Configuration

To enable the PDF provider : 

```lang
sonata_media:
    default_context: default
    db_driver: doctrine_orm
    contexts:
        default:
            providers:
                - sonata.media.provider.dailymotion
                - sonata.media.provider.youtube
                - sonata.media.provider.image
                - sonata.media.provider.file
                - sonata.media.provider.pdf
sonata_media_extra:
    providers:
        pdf:               
            resizer: sonata.media.resizer.square
```

To use the LiipImagineThumbnail

```lang
sonata_media_extra:
    providers:
        pdf:
            resizer: sonata.media.resizer.square
            thumbnail: sonata.media.thumbnail.liip_imagine
            
liip_imagine:
    filter_sets:
        default_square:
            quality: 80
            controller_action: 'SonataMediaExtraBundle:Media:liipImagineFilter'
            filters:
                thumbnail: { size: [130, 130], mode: outbound }
                
services:
    sonata.media.cdn.server:
        class: Concretis\SonataMediaExtraBundle\CDN\Server
        arguments: [~]
```
