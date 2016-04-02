<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 * @Template()
	 */
	public function indexAction()
	{
		return ['newsCollection' => $this->get('app.news_importer')->importFromJsonFile('news.json')];
	}
}