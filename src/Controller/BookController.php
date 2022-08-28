<?php
/**
 * Book Controller.
 */

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Reservation;
use App\Form\Type\ReservationType;
use App\Form\Type\BookType;
use App\Service\BookServiceInterface;
use App\Service\UserServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController.
 */
#[Route('/book')]
class BookController extends AbstractController
{
    /**
     * Book service.
     */
    private BookServiceInterface $bookService;

    /**
     * translator
     */
    private TranslatorInterface $translator;

    /**
     * User service.
     */
    private UserServiceInterface $userService;
    /**
     * construct function.
     *
     * @param TranslatorInterface  $translator  Translator
     *
     * @param BookServiceInterface $bookService Book Service
     *
     * @param UserServiceInterface $userService User Service
     *
     */
    public function __construct(TranslatorInterface $translator, BookServiceInterface $bookService, UserServiceInterface $userService)
    {
        $this->translator = $translator;
        $this->bookService = $bookService;
        $this->userService = $userService;
    }

    /**
     * Index function.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     */
    #[Route(
        name: 'book_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $user = $this->getUser();
            $pagination = $this->bookService->getPaginatedList(
                $request->query->getInt('page', 1),
                $user,
                $filters
            );

        return $this->render(
            'book/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Book $book Book entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name:'book_show',
        requirements:['id' => '[1-9]\d*'],
        methods:'GET',
    )]
    #[IsGranted('VIEW', subject:'book')]
    public function show(Book $book): Response
    {
        return $this->render(
            'book/show.html.twig',
            ['book' => $book]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     */
    #[Route('/create', name:'book_create', methods:'GET|POST')]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $book = new Book();
        $book->setAuthor($user);

        $form = $this->createForm(
            BookType::class,
            $book,
            ['action' => $this->generateUrl('book_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->save($book);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     *
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     *
     */
    #[IsGranted('EDIT', subject: 'book')]
    #[Route('/{id}/edit', name: 'book_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Book $book): Response
    {
        if ($book->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('book_index');
        }

        $form = $this->createForm(
            BookType::class,
            $book,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('book_edit', ['id' => $book->getId()]),
            ]
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->save($book);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/edit.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'book_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('DELETE', subject: 'book')]
    public function delete(Request $request, Book $book): Response
    {
        if ($book->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('book_index');
        }

        $form = $this->createForm(
            BookType::class,
            $book,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('book_delete', ['id' => $book->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->delete($book);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/delete.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Reserve action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/reserve',
        name: 'book_reserve',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT',
    )]
    public function reserve(Request $request, Book $book): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(
            ReservationType::class,
            $reservation,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('book_reserve', ['id' => $book->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->reserve($reservation);

            $this->addFlash(
                'success',
                $this->translator->trans('message.reserved_successfully')
            );

            return $this->redirectToRoute('allBooks');
        }

        return $this->render(
            'book/reserve.html.twig',
            [
                'book' => $book,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * All function.
     *
     * shows all books available using getPaginatedAll.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/all',
        name: 'allBooks',
        methods: 'GET'
    )]
    public function books(Request $request): Response
    {
            $curruser = $this->userService->getCurrentUser();
            $user = $this->getUser();
            $filters = $this->getFilters($request);
            $pagination = $this->bookService->getPaginatedAll(
                $request->query->getInt('page', 1),
                $filters
            );

            return $this->render(
                'book/all.html.twig',
                [
                'pagination' => $pagination,
                ]
            );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id: int, tag_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        return $filters;
    }
}
