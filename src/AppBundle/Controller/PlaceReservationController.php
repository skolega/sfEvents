<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PlaceReservation;
use AppBundle\Entity\Notification;

class PlaceReservationController extends Controller
{

    /**
     * @Route("/placeReservation/add/{data}/{hour}/{id}/{offset}/{placeAdmin}", name="add_reservation")
     */
    public function addAction($data, $hour, $id, $offset, $placeAdmin)
    {
        $em = $this->getDoctrine()
                ->getManager();
        if ($hour == 24) {
            $reservationDate = new \DateTime($data . ' 23:59:00');
        } else {
            $reservationDate = new \DateTime($data . ' ' . $hour . ':00:00');
        }
        $reservation = new PlaceReservation();
        $reservation->setData($reservationDate);
        $place = $em->getRepository('AppBundle:Place')->find($id);
        $reservation->setPlace($place);
        $reservation->setRepeatable(false);
        $user = $this->getUser();
        $reservation->setReservedBy($user);
        if ($placeAdmin == 1) {
            $reservation->setType(3);
            $reservation->setStatus(3);
        } else {
            $reservation->setType(2);
            $reservation->setStatus(1);
            
//            $notification = new Notification();
//            $notification->setType(7);
//            $notification->addUser($this->getUser());
//            $notification->addPlace($place);
//            
//            $em->persist($notification);
//            
//            $em->flush();
        }

        $em->persist($reservation);

        $em->flush();

        return $this->redirectToRoute('place_show', [
                    'id' => $id,
                    'date' => $offset,
        ]);
    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/confirm/reservation/{reservationId}/{offset}", name="confirm_reservation")
     */
    public function confirmAction($offset, $reservationId)
    {
        $em = $this->getDoctrine()
                ->getManager();

        $reservation = $em->getRepository('AppBundle:PlaceReservation')
                ->find($reservationId);

        $reservation->setStatus(2);

        $em->flush();

        $place = $reservation->getPlace();
        $id = $place->getId();

        return $this->redirectToRoute('place_show', [
                    'id' => $id,
                    'date' => $offset,
        ]);
    }

    /**
     * @Route("/placereservation/index/{date}/{id}/{offset}", name="place_reservation_index")
     */
    public function indexAction($date, $id, $offset)
    {

        $startDate = new \DateTime($date);
        $endDate = new \DateTime($date);

        $reservations = $this->getDoctrine()
                ->getRepository('AppBundle:PlaceReservation')
                ->getDayReservation($id, $startDate, $endDate);

        $place = $this->getDoctrine()->getRepository('AppBundle:Place')->find($id);
        $placeAdmins = $place->getAdmin();
        $user = $this->getUser();
        foreach ($placeAdmins as $placeAdmin) {
            if ($user == $placeAdmin) {
                $ifPlaceAdmin = 1;
                break;
            } else {
                $ifPlaceAdmin = 2;
            }
        }

        $dayCalendar = array();

        for ($i = 1; $i < 25; $i++) {
            $dayCalendar[$i] = [1];
        }

        foreach ($reservations as $reservation) {
            $type = $reservation->getType();
            $data = $reservation->getData();
            $data = date_format($data, 'H');
            $dataCloser = $reservation->getData();
            $dataCloser = date_format($dataCloser, 'H:i');
            $reservationId = $reservation->getId();
            $repeatable = $reservation->getRepeatable();
            $status = $reservation->getStatus();

            if ($dataCloser == '23:59') {
                $dayCalendar[24] = [2, $repeatable, $status, $ifPlaceAdmin, $reservationId, $type];
            } else {
                $dayCalendar[intval($data)] = [2, $repeatable, $status, $ifPlaceAdmin, $reservationId, $type];
            }
        }


        return $this->render('PlaceReservation/index.html.twig', [
                    'reservations' => $dayCalendar,
                    'id' => $id,
                    'thisDate' => $date,
                    'offset' => $offset,
                    'ifPlaceAdmin' => $ifPlaceAdmin,
        ]);
    }

}
