<?php
/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Tag;
use App\Form\Type\TagType;
use App\Service\TagServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class TagController.
 */
#[Route('/tag')]
class TagController extends AbstractController
{
    /**
     * Tag service.
     */
    private TagServiceInterface $tagService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * construct function.
     *
     * @param TagServiceInterface $tagService Tag Service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(TagServiceInterface $tagService, TranslatorInterface $translator)
    {
        $this->tagService = $tagService;
        $this->translator = $translator;
    }

    /**
     * Index function.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'tag_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->tagService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('Tag/index.html.twig', ['pagination' => $pagination]);
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
        name: 'tag_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->tagService->save($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'Tag/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Show action.
     *
     * @param Tag $tag Tag entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{slug}',
        name: 'tag_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    #[ParamConverter('tag')]
    public function show(Tag $tag): Response
    {
        return $this->render('Tag/show.html.twig', ['tag' => $tag]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Tag     $tag     Tag entity
     *
     * @return Response HTTP response
     */
    #[Route('/{slug}/edit', name: 'tag_edit', methods: 'GET|PUT|POST')]
    #[ParamConverter('tag')]
    public function edit(Request $request, Tag $tag): Response
    {
        $form = $this->createForm(
            TagType::class,
            $tag,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('tag_edit', ['slug' => $tag->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->tagService->save($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'Tag/edit.html.twig',
            [
                'form' => $form->createView(),
                'tag' => $tag,
            ]
        );
    }

    /**
     * delete action.
     *
     * @param Request $request HTTP request
     * @param Tag     $tag     Tag entity
     *
     * @return Response HTTP response
     */
    #[Route('/{slug}/delete', name: 'tag_delete', methods: 'GET|DELETE')]
    public function delete(Request $request, Tag $tag): Response
    {
        $form = $this->createForm(
            TagType::class,
            $tag,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('tag_delete', ['slug' => $tag->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->delete($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'Tag/delete.html.twig',
            [
                'form' => $form->createView(),
                'tag' => $tag,
            ]
        );
    }
}
