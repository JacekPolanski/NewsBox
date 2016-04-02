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
	 *
	 * @return array
	 */
	public function indexAction()
	{
		return ['newsCollection' => $this->get('app.news_importer')->importFromJsonFile('news.json')];
	}

	/**
	 * @Route("/news/{id}", name="news", requirements={"id": "\d+"})
	 * @Template()
	 *
	 * @param $id
	 * @return array
	 */
	public function newsAction($id)
	{
		$news = $this->get('app.news_manager')->findById((int) $id);

		if (!$news) {
			throw $this->createNotFoundException(sprintf('Brak elementu o id = %d', $id));
		}

		return ['news' => $news];
	}
}