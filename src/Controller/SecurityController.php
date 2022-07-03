<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\loginFormType;
use App\Form\Type\registerFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function RegistrationProcessAction(Request $request, UserRepository $userRepository,ManagerRegistry $managerRegistry,ValidatorInterface  $validator)
    {
        $user = new User();
        $formRegister = $this->createForm(registerFormType::class, $user);
        $formRegister->handleRequest($request);

        if($formRegister->isSubmitted())
        {
            $username = $formRegister->get('username')->getData();
            $checkUsername = $userRepository->checkUserName($username);

            if($checkUsername[0]['count_user'] == 0)
            {
                if($formRegister->isValid())
                {
                    //get data from register form and set user data
                    $this->setUserDateRegister($user, $formRegister);
                    $user->setRoles(['ROLE_USER']);

                    // push data to database
                    $database = $managerRegistry->getManager();
                    $database->persist($user);
                    $database->flush();

                    return $this->redirectToRoute("app_login");
                }
                else
                {
                    $errorRegister = $validator->validate($user);
                    return $this->redirectToRoute('app_login', [
                        'errorRegister' => $errorRegister
                    ]);
                }
            }
            else
            {
                    $errorRegister = 'Username exist';
                     return $this->redirectToRoute('app_login', [
                         'errorRegister' => $errorRegister
                     ]);
            }

        }
        return new JsonResponse(['status_code' => 404]);
    }

    /**
     * @Route ("/registrationAdmin", name="app_registration_admin", methods={"POST", "GET"})
     */
    public function RegistrationAdminProcessAction(Request $request, UserRepository $userRepository,ManagerRegistry $managerRegistry,ValidatorInterface  $validator)
    {
        $user = new User();
        $formRegister = $this->createForm(registerFormType::class, $user);
        $formRegister->handleRequest($request);
        $error = false;

        if($formRegister->isSubmitted())
        {
            $username = $formRegister->get('username')->getData();
            $checkUsername = $userRepository->checkUserName($username);

            if($checkUsername[0]['count_user'] == 0)
            {
                if($formRegister->isValid())
                {
                    //get data from register form and set user data
                    $this->setUserDateRegister($user, $formRegister);
                    $user->setRoles(['ROLE_ADMIN']);

                    // push data to database
                    $database = $managerRegistry->getManager();
                    $database->persist($user);
                    $database->flush();

                    $errorRegisterAdmin = 'Success register';
                    return $this->render('admin/collaborators/collaborators.html.twig', [
                        'error' => $error,
                        'errorRegisterAdmin' => $errorRegisterAdmin,
                        'RegisterAdmin' => $formRegister->createView()
                    ]);
                }
                else
                {
                    $error = true;
                    $errorRegisterAdmin = $this->getErrorRegister($validator->validate($user));
                    return $this->render('admin/collaborators/collaborators.html.twig', [
                        'error' => $error,
                        'errorRegisterAdmin' => $errorRegisterAdmin,
                        'RegisterAdmin' => $formRegister->createView()
                    ]);
                }
            }
            else
            {
                $errorRegisterAdmin = 'Username exist';
                return $this->render('admin/collaborators/collaborators.html.twig', [
                    'error' => $error,
                    'errorRegisterAdmin' => $errorRegisterAdmin,
                    'RegisterAdmin' => $formRegister->createView()
                ]);
            }

        }
        else
        {
            $errorRegisterAdmin = '';
            return $this->render('admin/collaborators/collaborators.html.twig', [
                'error' => $error,
                'errorRegisterAdmin' => $errorRegisterAdmin,
                'RegisterAdmin' => $formRegister->createView()
            ]);
        }
    }

    public function setUserDateRegister($user, $formRegister)
    {
        $user->setUsername($formRegister->get('username')->getData());
        $user->setFullname($formRegister->get('fullname')->getData());
        $user->setPassword($formRegister->get('password')->getData());
        $user->setGender($formRegister->get('gender')->getData());
        $user->setAvatar('avatar.png');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user, $formRegister->get('password')->getData())
        );
        $user->setLoginStatus('offline');
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login(Request $request ,AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $errorLogin = $authenticationUtils->getLastAuthenticationError();
        $errorRegister = $request->query->get('errorRegister');
        $errorRegister = $this->getErrorRegister($errorRegister);

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

    public function getErrorRegister($errorRegister)
    {
        if(!($errorRegister == 'Username available') && $errorRegister != '')
        {
            $userCutLength = 56;
            $fullnameCutLength = 56;

            $indexUsername = strpos($errorRegister, 'username');
            if ($indexUsername > 0) {
                $errorRegister = substr($errorRegister, $indexUsername + 10, $userCutLength);
            } else {
                $indexFullname = strpos($errorRegister, 'fullname');
                $errorRegister = substr($errorRegister, $indexFullname + 10, $fullnameCutLength);
            }
        }

        return $errorRegister;
    }


    /**
     * @Route("/processLogout", name="app_process_logout")
     */
    public function processLogout(UserRepository $userRepository, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($this->getUser()->getId());
        $user->setLoginStatus('offline');

        $database = $managerRegistry->getManager();
        $database->persist($user);
        $database->flush();

        return $this->redirectToRoute('app_logout');
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
