<?php
/**
 * Profile Controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Form\Type\UserPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\UserServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * translator.
     */
    private TranslatorInterface $translator;
    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * construct function.
     *
     * @param UserServiceInterface        $userService    User Service
     * @param TranslatorInterface         $translator     Translator
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
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
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route(path: '/{id}/profile_edit', name: 'profile_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|POST')]
    #[IsGranted('EDIT', subject: 'user')]
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('profile_edit', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

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

    /**
     * Edit action for user password.
     *
     * Used for editing user profile data
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route(path: '/{id}/password_edit', name: 'password_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|POST')]
    #[IsGranted('EDIT_PASSWORD', subject: 'user')]
    public function editPassword(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(
            UserPasswordType::class,
            $user,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('password_edit', ['id' => $user->getId()]),
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
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->userService->save($user);
            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('app_profile');
        }

        return $this->render(
            'profile/editPassword.html.twig',
            [
                'user' => $user,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * delete action.
     *
     * @param Request $request HTTP request
     * @param User    $user    User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'user_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE|POST')]
    #[IsGranted('DELETE', subject: 'user')]
    public function delete(Request $request, User $user): Response
    {
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('user_delete', ['id' => $user->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->delete($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render(
            'profile/delete.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Show action.
     *
     * @param User $user User entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'user_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    #[IsGranted('VIEW', subject: 'user')]
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', ['user' => $user]);
    }
}
