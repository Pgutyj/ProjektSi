<?php
/**
 * Profile Controller.
 */
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\UserServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfileController.
 */
#[Route(path: '/profile')]
class ProfileController extends AbstractController
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
     * Index function.
     *
     * @return Response HTTP response
     *
     */
    #[Route(name: 'app_profile', methods: 'GET|POST')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->userService->getCurrentUser();

        return $this->render(
            'profile/profile.html.twig',
            ['user' => $user]
        );
    }

    /**
     * Edit action.
     *
     * Used for editing user profile data
     *
     * @param Request $request HTTP request
     *
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     *
     */
    #[Route(path: '/{id}/profile_edit', name: 'profile_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $curruser = $this->userService->getCurrentUser();
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('profile_edit', ['id' => $user->getId()]),
            ]
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
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('app_profile');
        }

        return $this->render(
            'profile/edit.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }
}
