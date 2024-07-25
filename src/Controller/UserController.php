<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{

    #[Route('/users', name: 'app_users')]
    public function listUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/edit_user/{id}', name: 'app_user_edit')]
    public function editUser($id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {    
        $user = $userRepository->find($id);
    
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_users');
        }
    
        return $this->render('user/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route('/delete_user/{id}', name: 'app_user_delete')]
    public function deleteUser($id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {    
        $user = $userRepository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_users');

    }

}