<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\loginFormType;
use App\Form\Type\registerFormType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function RegistrationProcessAction(Request $request, ManagerRegistry $managerRegistry,ValidatorInterface  $validator)
    {
        $user = new User();
        $formRegister = $this->createForm(registerFormType::class, $user);
        $formRegister->handleRequest($request);

        if($formRegister->isSubmitted())
        {
            //get data from register form
            $user->setUsername($formRegister->get('username')->getData());
            $user->setFullname($formRegister->get('fullname')->getData());
            $user->setPassword($formRegister->get('password')->getData());
            $user->setGender($formRegister->get('gender')->getData());

            if($formRegister->isValid())
            {
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user, $formRegister->get('password')->getData())
                );
                $user->setRoles(['ROLE_USER']);

                // push data to database
                $database = $managerRegistry->getManager();
                $database->persist($user);
                $database->flush();

                return $this->redirectToRoute("app_login", [

                ]);
            }
            else
            {
                $errorRegister = $validator->validate($user);
                if(count($errorRegister) > 0 )
                {
                    $errorsString = (string) $errorRegister;
                }
                return $this->redirectToRoute('app_login', [
                   'errorRegister' => $errorsString
                ]);
            }
        }
        return new Response('register', 200);
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $errorLogin = $authenticationUtils->getLastAuthenticationError();
        $errorRegister = '';
        if(isset($_GET['errorRegister']))
        {
            $errorRegister = $_GET['errorRegister'];
        }

        // create form
        $user = new User();
        $loginForm = $this->createForm(loginFormType::class, $user);
        $registerForm = $this->createForm(registerFormType::class, $user);


        return $this->render('security/login.html.twig', [
                'errorLogin' => $errorLogin,
                'errorRegister' => $errorRegister,
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
