<?php
/**
 * Reservation Controller.
 */

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Type\ManageType;
use App\Service\ReservationServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * construct function.
     *
     * @param ReservationServiceInterface $reservationService Reservation Service
     * @param TranslatorInterface         $translator         translator
     */
    public function __construct(ReservationServiceInterface $reservationService, TranslatorInterface $translator)
    {
        $this->reservationService = $reservationService;
        $this->translator = $translator;
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

        return $this->render('book/reservations.html.twig', ['pagination' => $pagination]);
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
            if ('approved' === $reservationStatus->getStatusInfo()) {
                $book = $reservation->getBook();
                $book->setAuthor($reservation->getRequester());
            } else {
                $book = $reservation->getBook();
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
            'book/manage.html.twig',
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

        return $this->render('book/yourReservations.html.twig', ['pagination' => $pagination]);
    }
}
