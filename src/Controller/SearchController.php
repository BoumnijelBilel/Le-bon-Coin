<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $search = $request->query->get('search_query', '');

        if (empty($search)) {
            return $this->render('search/index.html.twig', [
                'searched' => $search,
                'posts' => []
            ]);
        }

        $posts = $postRepository->findByTitleLike($search);

        return $this->render('search/index.html.twig', [
            'searched' => $search,
            'posts' => $posts
        ]);
    }
}
