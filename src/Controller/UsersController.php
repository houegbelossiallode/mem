<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['nom' => 'asc']);
        return $this->render('users/index.html.twig', [
           'users'=> $users,
        ]);
    }



    #[IsGranted("ROLE_ADMIN")]
    #[Route('/users/role/{id}', name: 'app_role')]
    public function role(Request $request,ManagerRegistry $doctrine,int $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
          
            $user->setRoles($form->get('roles')->getData());
            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();
            
            $this->addFlash('success','Rôle affecté avec succès');
            
            
            return $this->redirectToRoute('app_dashboard');
        }
        
        return $this->render('users/role.html.twig', [
            'user' => $user->getId(),
            'form' => $form->createView(),
            
            
        ]);
    }








    
}