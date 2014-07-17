<?php
namespace MyApp\GlobalBundle;
//use Presta\SitemapBundle\Event\SitemapPopulateEvent;
//use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MyAppGlobalBundle extends Bundle
{
	/*public function boot()
	{
		$router = $this->container->get('router');
		$event  = $this->container->get('event_dispatcher');
	
		//listen presta_sitemap.populate event
		$event->addListener(SitemapPopulateEvent::onSitemapPopulate, function(SitemapPopulateEvent $event) use ($router){
			//get absolute homepage url
			$url = $router->generate('homepage', array(), true);
			//add homepage url to the urlset named default
			$event->getGenerator()->addUrl(new UrlConcrete($url, new \DateTime(), UrlConcrete::CHANGEFREQ_HOURLY, 1), 'default');
		});
	}*/
	
}
