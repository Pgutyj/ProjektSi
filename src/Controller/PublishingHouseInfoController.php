<?php
/**
 * Publishing House info controller.
 */

namespace App\Controller;

use App\Entity\PublishingHouseInfo;
use App\Service\PublishingHouseInfoServiceInterface;
use App\Form\Type\PublishingHouseInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PublishingHouseInfoController.
 */
#[Route('/publishingHouseInfo')]
class PublishingHouseInfoController extends AbstractController
{
    /**
     * Publishing House service.
     */
    private PublishingHouseInfoServiceInterface $publishingHouseInfoService;

    /**
     * Constructor.
     */
    private TranslatorInterface $translator;

    /**
     * construct function.
     *
     * @param PublishingHouseInfoServiceInterface $publishingHouseInfoService PublishingHouse Info Service
     * @param TranslatorInterface                 $translator                 Translator
     */
    public function __construct(PublishingHouseInfoServiceInterface $publishingHouseInfoService, TranslatorInterface $translator)
    {
        $this->publishingHouseInfoService = $publishingHouseInfoService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'publishing_house_info_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->publishingHouseInfoService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('publishingHouseInfo/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'publishing_house_info_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(PublishingHouseInfo $publishingHouseInfo): Response
    {
        return $this->render('publishingHouseInfo/show.html.twig', ['publishingHouseInfo' => $publishingHouseInfo]);
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
        name: 'publishing_house_info_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $publishingHouseInfo = new PublishingHouseInfo();
        $form = $this->createForm(PublishingHouseInfoType::class, $publishingHouseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->publishingHouseInfoService->save($publishingHouseInfo);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('publishing_house_info_index');
        }

        return $this->render(
            'publishingHouseInfo/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * edit action.
     *
     * @param Request             $request                    HTTP request
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'publishing_house_info_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|POST')]
    public function edit(Request $request, PublishingHouseInfo $publishingHouseInfo): Response
    {
        $form = $this->createForm(
            PublishingHouseInfoType::class,
            $publishingHouseInfo,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('publishing_house_info_edit', ['id' => $publishingHouseInfo->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->publishingHouseInfoService->save($publishingHouseInfo);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('publishing_house_info_index');
        }

        return $this->render(
            'publishingHouseInfo/edit.html.twig',
            [
                'form' => $form->createView(),
                'publishingHouseInfo' => $publishingHouseInfo,
            ]
        );
    }

    /**
     * delete action.
     *
     * @param Request             $request                    HTTP request
     * @param PublishingHouseInfo $publishingHouseInfoService PublishingHouseInfo entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'publishing_house_info_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, PublishingHouseInfo $publishingHouseInfo): Response
    {
        if (!$this->publishingHouseInfoService->canBeDeleted($publishingHouseInfo)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.publishing_house_contains_book')
            );

            return $this->redirectToRoute('publishing_house_info_index');
        }

        $form = $this->createForm(
            PublishingHouseInfoType::class,
            $publishingHouseInfo,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('publishing_house_info_delete', ['id' => $publishingHouseInfo->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->publishingHouseInfoService->delete($publishingHouseInfo);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('publishing_house_info_index');
        }

        return $this->render(
            'publishingHouseInfo/delete.html.twig',
            [
                'form' => $form->createView(),
                'publishingHouseInfo' => $publishingHouseInfo,
            ]
        );
    }
}
