<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FotoJoin\FrontPageBundle\FotoJoinFrontPageBundle(),
            new FotoJoin\ControlPanelBundle\FotoJoinControlPanelBundle(),
            new FotoJoin\AdminBundle\FotoJoinAdminBundle(),
            new FotoJoin\UserBundle\FotoJoinUserBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new FotoJoin\GalleryBundle\FotoJoinGalleryBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new Oneup\UploaderBundle\OneupUploaderBundle(),
            new FotoJoin\GeneratorBundle\FotoJoinGeneratorBundle(),
            new FotoJoin\AdminGeneratorBundle\FotoJoinAdminGeneratorBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
