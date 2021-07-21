<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Security $security, UserRepository $userRepository): Response
    {
        $userSecurity = $security->getUser();
        if ($userSecurity == null) {
            return $this->redirectToRoute('home');
        }
        $user = $userRepository->findOneBy(['username' => $userSecurity->getUserIdentifier()]);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/profile/posts", name="profile_posts")
     */
    public function post(Security $security, UserRepository $userRepository, PostRepository $postRepository): Response
    {
        $userSecurity = $security->getUser();
        if ($userSecurity == null) {
            return $this->redirectToRoute('home');
        }
        $user = $userRepository->findOneBy(['username' => $userSecurity->getUserIdentifier()]);
        $posts = $postRepository->findBy(['author' => $user], ['publishedAt' => 'DESC']);
        return $this->render('profile/post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
