<?php
/**
 * Reservation Controller.
 */

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Type\ManageType;
use App\Form\Type\ReservationType;
use App\Service\ReservationServiceInterface;
use App\Service\ReservationStatusServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use DateTimeImmutable;

/**
 * Class ReservationController.
 */
#[Route(path: '/reservations')]
class ReservationController extends AbstractController
{
    /**
     * Reservation service.
     */
    private ReservationServiceInterface $reservationService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Reservation status service.
     */
    private ReservationStatusServiceInterface $reservationStatusService;

    /**
     * construct function.
     *
     * @param ReservationServiceInterface       $reservationService       Reservation Service
     * @param TranslatorInterface               $translator               translator
     * @param ReservationStatusServiceInterface $reservationStatusService Reservation Status Service
     */
    public function __construct(ReservationServiceInterface $reservationService, TranslatorInterface $translator, ReservationStatusServiceInterface $reservationStatusService)
    {
        $this->reservationService = $reservationService;
        $this->translator = $translator;
        $this->reservationStatusService = $reservationStatusService;
    }

    /**
     * Index function.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(path: '/appReservations', name: 'app_reservations', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->reservationService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('reservation/reservations.html.twig', ['pagination' => $pagination]);
    }

    /**
     * manage actions.
     *
     * Used for managing reservation_status
     *
     * @param Request     $request     HTTP request
     * @param Reservation $reservation Reservation Entity
     *
     * @return Response HTTP response
     */
    #[Route(path: '/{id}/manage', name: 'reservations_manage', methods: 'GET|POST')]
    public function manage(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(
            ManageType::class,
            $reservation,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('reservations_manage', ['id' => $reservation->getId()]),
            ]
        );

        $form->handleRequest($request);

        $reservationStatus = $reservation->getReservationStatus();

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $reservation->getBook();
            if ('approved' === $reservationStatus->getStatusInfo()) {
                $book->setAuthor($reservation->getRequester());
            } else {
                $book->setAuthor(null);
            }

            $this->reservationService->save($reservation);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('app_reservations');
        }

        return $this->render(
            'reservation/manage.html.twig',
            [
                'reservation' => $reservation,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Reservations of a certain user.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'your_reservations', methods: 'GET')]
    public function yourReservations(Request $request): Response
    {
        $user = $this->getUser();

        $pagination = $this->reservationService->getPaginatedReservations(
            $request->query->getInt('page', 1),
            $user
        );

        return $this->render('reservation/yourReservations.html.twig', ['pagination' => $pagination]);
    }

    /**
     * edit action.
     *
     * @param Request     $request     HTTP request
     * @param Reservation $reservation Reservation entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'reservation_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|POST')]
    #[IsGranted('EDIT', subject: 'reservation')]
    public function edit(Request $request, Reservation $reservation): Response
    {
        if ($reservation->getRequester() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.access_denied')
            );

            return $this->redirectToRoute('your_reservations');
        }

        $form = $this->createForm(
            ReservationType::class,
            $reservation,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('reservation_edit', ['id' => $reservation->getId()]),
            ]
        );
        $timestamp = time();
        $date = (new DateTimeImmutable())->setTimestamp($timestamp);
        $reservation->setReservationTime($date);
        $reservationStatus = $this->reservationStatusService->findOneById(1);
        $reservation->setReservationStatus($reservationStatus);
        $book = $reservation->getBook();
        $book->setAuthor(null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('security.csrf.token_manager')->refreshToken('form_intention');

            $this->reservationService->save($reservation);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('your_reservations');
        }

        return $this->render(
            'reservation/edit.html.twig',
            [
                'form' => $form->createView(),
                'reservation' => $reservation,
            ]
        );
    }

    /**
     * delete action.
     *
     * @param Request     $request     HTTP request
     * @param Reservation $reservation Reservation Entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'reservation_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE|POST')]
    #[IsGranted('DELETE', subject: 'reservation')]
    public function delete(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(
            ReservationType::class,
            $reservation,
            [
                'method' => 'POST',
                'action' => $this->generateUrl('reservation_delete', ['id' => $reservation->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReservationStatus(null);
            $reservation->setBook(null);
            $this->reservationService->delete($reservation);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('your_reservations');
        }

        return $this->render(
            'reservation/delete.html.twig',
            [
                'form' => $form->createView(),
                'reservation' => $reservation,
            ]
        );
    }

    /**
     * Show action.
     *
     * @param Reservation $reservation Reservation entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'reservation_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    #[IsGranted('VIEW', subject: 'reservation')]
    public function show(Reservation $reservation): Response
    {
        if ($reservation->getRequester() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.access_denied')
            );

            return $this->redirectToRoute('your_reservations');
        }

        return $this->render('reservation/show.html.twig', ['reservation' => $reservation]);
    }
}
