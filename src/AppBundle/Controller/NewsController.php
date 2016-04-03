<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class NewsController
 * @package AppBundle\Controller
 */
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
        $newsCollection = $this->get('app.news_repository')->findAll();

        if (!$newsCollection) {
            throw $this->createNotFoundException('Brak elementów');
        }

        return ['newsCollection' => $this->get('app.news_repository')->findAll()];
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
        $news = $this->get('app.news_repository')->findById((int)$id);

        if (!$news) {
            throw $this->createNotFoundException(sprintf('Brak elementu o id = %d', $id));
        }

        return ['news' => $news];
    }
}