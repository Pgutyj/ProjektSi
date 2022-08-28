<?php
/**
 * Security Controller.
 */
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Entity\Enum\UserRole;
use App\Service\UserServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SecurityController.
 */
class SecurityController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * translator
     */
    private TranslatorInterface $translator;

    /**
     * Password hasher
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * construct function.
     *
     * @param UserService                 $userService    User Service
     *
     * @param TranslatorInterface         $translator     Translator
     *
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     *
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Login function.
     *
     * @param AuthenticationUtils $authenticationUtils HTTP authentication
     *
     * @return Response HTTP response
     *
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * Logout function.
     */
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * signup action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     */
    #[Route(path:'/signup', name:'app_signup', methods:'GET|POST')]
    public function signup(Request $request): Response
    {
        $user = new User();
        $user->setRoles([UserRole::ROLE_USER->value]);
        $form = $this->createForm(
            UserType::class,
            $user,
            ['action' => $this->generateUrl('app_signup')]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $user->getPassword();
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $password
                )
            );
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'security/signup.html.twig',
            ['form' => $form->createView()]
        );
    }
}
