<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Repository\StatutRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Task;
use App\Form\TaskType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }

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

    #[Route('/project/{id}', name: 'app_detail')]
    public function projectDetail($id, StatutRepository $statutRepository, TaskRepository $taskRepository, ProjectRepository $projectRepository ): Response
    {

        $project = $projectRepository->find($id);        
        $statuts = $statutRepository->findAll();
        $tasks = $taskRepository->findBy(['projectId' => $project]);

        return $this->render('home/project.html.twig', [
            'tasks' => $tasks,
            'project' => $project,
            'statuts' => $statuts,

        ]);

    }


    #[Route('/add_task/{id}', name: 'app_task_add')]
    public function register($id, Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository, ProjectRepository $projectRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        $project = $projectRepository->find($id);  

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setProjectId($project);

            
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/addTask.html.twig', [
            'taskForm' => $form->createView(),
            'project' =>$id,
        ]);
    }

    #[Route('/edit_task/{id}', name: 'app_task_edit')]
    public function editTask($id, Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response
    {    
        $task = $taskRepository->find($id);
    
        if (!$task) {
            throw $this->createNotFoundException('No task found for id '.$id);
        }
    
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de persister une entité existante
            $entityManager->flush();
    
            return $this->redirectToRoute('app_home');
        }
    
        return $this->render('home/editTask.html.twig', [
            'taskForm' => $form->createView(),
            'task' => $task,
        ]);
    }
    

    #[Route('/delete_task/{id}', name: 'app_task_delete')]
    public function deleteTask($id, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response
    {    
        $task = $taskRepository->find($id);
        $ProjectId = $task->getProjectId();
        $idP = $ProjectId->getId();

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_detail', ['id' => $idP]);

    }
}
