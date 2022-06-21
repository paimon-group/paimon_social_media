<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\loginFormType;
use App\Form\Type\registerFormType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route ("/registration", name="app_registration", methods="POST")
     */
    public function RegistrationProcessAction(Request $request, ManagerRegistry $managerRegistry)
    {
        $user = new User();
        $formRegister = $this->createForm(registerFormType::class, $user);
        $formRegister->handleRequest($request);

        if($formRegister->isSubmitted() && $formRegister->isValid())
        {
            //get data from register form
            $user->setUsername($formRegister->get('username')->getData());
            $user->setPassword($this->passwordHasher->hashPassword(
                $user, $formRegister->get('password')->getData())

            );
            $user->setFullname($formRegister->get('fullname')->getData());
            $user->setGender($formRegister->get('gender')->getData());
            $user->setRoles(['ROLE_USER']);

            // push data to database
            $database = $managerRegistry->getManager();
            $database->persist($user);
            $database->flush();

            return $this->redirectToRoute("app_login");
        }

    }

    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        // create form
        $user = new User();
        $loginForm = $this->createForm(loginFormType::class, $user);
        $registerForm = $this->createForm(registerFormType::class, $user);

        return $this->render('security/login.html.twig', [
                'error' => $error,
                'last_username' => $lastUsername,
                'Login' => $loginForm->createView(),
                'Register' => $registerForm->createView()
            ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
