<?php
/**
 * Author info controller.
 */

namespace App\Controller;

use App\Entity\AuthorInfo;
use App\Service\AuthorInfoServiceInterface;
use App\Form\Type\AuthorInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AuthorInfoController.
 */
#[Route('/authorInfo')]
class AuthorInfoController extends AbstractController
{
    /**
     * Author info service.
     */
    private AuthorInfoServiceInterface $authorInfoService;

    /**
     * Constructor.
     */
    private TranslatorInterface $translator;

    /**
     * construct function.
     *
     * @param AuthorInfoServiceInterface $authorInfoService author Info Service
     * @param TranslatorInterface        $translator        Translator
     */
    public function __construct(AuthorInfoServiceInterface $authorInfoService, TranslatorInterface $translator)
    {
        $this->authorInfoService = $authorInfoService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'author_info_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->authorInfoService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('authorInfo/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'author_info_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $authorInfo = new AuthorInfo();
        $form = $this->createForm(AuthorInfoType::class, $authorInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorInfoService->save($authorInfo);
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('author_info_index');
        }

        return $this->render(
            'authorInfo/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Show action.
     *
     * @param AuthorInfo $authorInfo AuthorInfo entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}',
        name: 'author_info_show',
        methods: 'GET'
    )]
    #[ParamConverter('authorInfo')]
    public function show(AuthorInfo $authorInfo): Response
    {
        return $this->render('authorInfo/show.html.twig', ['authorInfo' => $authorInfo]);
    }

    /**
     * edit action.
     *
     * @param Request    $request    HTTP request
     * @param AuthorInfo $authorInfo AuthorInfo entity
     *
     * @return Response HTTP response
     */
    #[Route('/{slug}/edit', name: 'author_info_edit', methods: 'GET|POST')]
    #[ParamConverter('authorInfo')]
    public function edit(Request $request, AuthorInfo $authorInfo): Response
    {
        $form = $this->createForm(
            AuthorInfoType::class,
            $authorInfo,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('author_info_edit', ['slug' => $authorInfo->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorInfoService->save($authorInfo);
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('author_info_index');
        }

        return $this->render(
            'authorInfo/edit.html.twig',
            [
                'form' => $form->createView(),
                'authorInfo' => $authorInfo,
            ]
        );
    }

    /**
     * delete action.
     *
     * @param Request    $request    HTTP request
     * @param AuthorInfo $authorInfo AuthorInfo entity
     *
     * @return Response HTTP response
     */
    #[Route('/{slug}/delete', name: 'author_info_delete', methods: 'GET|DELETE|POST')]
    #[ParamConverter('authorInfo')]
    public function delete(Request $request, AuthorInfo $authorInfo): Response
    {
        if (!$this->authorInfoService->canBeDeleted($authorInfo)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.author_contains_book')
            );

            return $this->redirectToRoute('author_info_index');
        }

        $form = $this->createForm(
            AuthorInfoType::class,
            $authorInfo,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('author_info_delete', ['slug' => $authorInfo->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->authorInfoService->delete($authorInfo);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('author_info_index');
        }

        return $this->render(
            'authorInfo/delete.html.twig',
            [
                'form' => $form->createView(),
                'authorInfo' => $authorInfo,
            ]
        );
    }
}