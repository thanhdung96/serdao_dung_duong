<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService
    ) { }

    #[Route(path: '/users', name: 'user_index', methods: [ Request::METHOD_GET, Request::METHOD_POST ])]
    public function index(Request $request): Response{
        $users = $this->userService->findAllUsers();
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);

        if($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $newUser = $form->getData();
                $errors = $this->userService->validateUser($newUser);

                if(sizeof($errors)) {
                    $this->addFlash('fail', 'Input errors');
                    return $this->render('user.html.twig', [
                        'users' => $users,
                        'newUser' => $newUser,
                        'form' => $form->createView(),
                        'errors' => $errors
                    ]);
                }

                $this->userService->newUser($newUser);
                return $this->redirectToRoute('user_index');
            }
        }


        return $this->render('user.html.twig', [
            'users' => $users,
            'newUser' => $newUser,
            'form' => $form->createView()
        ]);
    }

    #[Route(path: '/users/{userId}/delete', name: 'user_delete', methods: Request::METHOD_POST)]
    public function deleteUser(Request $request, string $userId): Response{
        $submittedToken = $request->request->get('token');

        // 'delete-item' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $userToDelete = $this->userService->findUserById($userId);
            if(!is_null($userToDelete)) {
                $this->userService->removeUser($userToDelete);
                $this->addFlash('success', 'User deleted');
            } else {
                $this->addFlash('fail', 'User not found');
            }
        } else {
            $this->addFlash('fail', 'Invalid token');
        }

        return $this->redirectToRoute('user_index');
    }
}