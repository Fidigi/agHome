<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        return $this->render('front/home.html.twig', [
            'h1_title' => "Home page!",
        ]);
    }
    
    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin()
    {
        return $this->render('admin/home.html.twig', [
            'h1_title' => "Admin page!",
        ]);
    }
    
    /**
     * @Route("/back", name="app_back")
     */
    public function back()
    {
        return $this->render('back/home.html.twig', [
            'h1_title' => "Back page!",
        ]);
    }
    
    /**
     * @Route("/profile", name="app_profile")
     */
    public function profile()
    {
        return $this->render('profile/home.html.twig', [
            'h1_title' => "Profile page!",
        ]);
    }
    
    /**
     * @Route("/api/", name="app_api_slashe")
     */
    public function apiSlashe()
    {
        return $this->api();
    }
    
    /**
     * @Route("/api", name="app_api")
     */
    public function api()
    {
        $data = [
            'message' => "OK"
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
    
}
