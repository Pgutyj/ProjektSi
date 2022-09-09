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
use App\Service\ReservationServiceInterface;
use App\Service\ReservationStatusServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

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
     * translator.
     */
    private TranslatorInterface $translator;

    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Reservation service.
     */
    private ReservationServiceInterface $reservationService;

    /**
     * Reservation status service.
     */
    private ReservationStatusServiceInterface $reservationStatusService;

    /**
     * construct function.
     *
     * @param TranslatorInterface               $translator               Translator
     * @param BookServiceInterface              $bookService              Book Service
     * @param UserServiceInterface              $userService              User Service
     * @param ReservationServiceInterface       $reservationService       Reservation Service
     * @param ReservationStatusServiceInterface $reservationStatusService Reservation Status Service
     */
    public function __construct(TranslatorInterface $translator, BookServiceInterface $bookService, UserServiceInterface $userService, ReservationServiceInterface $reservationService, ReservationStatusServiceInterface $reservationStatusService)
    {
        $this->translator = $translator;
        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->reservationService = $reservationService;
        $this->reservationStatusService = $reservationStatusService;
    }

    /**
     * Index function.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
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
        name: 'book_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
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
     */
    #[Route('/create', name: 'book_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        $book = new Book();
        $book->setAuthor(null);

        $form = $this->createForm(
            BookType::class,
            $book,
            ['action' => $this->generateUrl('book_create')]
        );
        $timestamp = time();
        $date = (new DateTimeImmutable())->setTimestamp($timestamp);
        $book->setBookCreationTime($date);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->save($book);
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

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
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'book_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(
            BookType::class,
            $book,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('book_edit', ['id' => $book->getId()]),
            ]
        );

        $timestamp = time();
        $date = (new DateTimeImmutable())->setTimestamp($timestamp);
        $book->setBookCreationTime($date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->save($book);
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

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
    public function delete(Request $request, Book $book): Response
    {
        if (!$this->bookService->canBeDeleted($book)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.book_contains_reservation')
            );

            return $this->redirectToRoute('allBooks');
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
        methods: 'GET|POST',
    )]
    public function reserve(Request $request, Book $book): Response
    {
        if (null !== $book->getAuthor()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.book_already_reserved')
            );

            return $this->redirectToRoute('allBooks');
        }

        $reservation = new Reservation();
        $form = $this->createForm(
            ReservationType::class,
            $reservation,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('book_reserve', ['id' => $book->getId()]),
            ]
        );
        $reservation->setBook($book);
        $user = $this->getUser();
        $reservation->setRequester($user);
        $reservation->setEmail($user->getEmail());
        $reservationStatus = $this->reservationStatusService->findOneById(1);
        $reservation->setReservationStatus($reservationStatus);
        $timestamp = time();
        $date = (new DateTimeImmutable())->setTimestamp($timestamp);
        $reservation->setReservationTime($date);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->reservationService->save($reservation);

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
