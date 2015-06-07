<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{

    /**
     * @Route("/add/message/{id}", name="add_message")
     */
    public function addAction(Event $event, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $message = new Message();

        $form = $this->createForm(new MessageType(), $message);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $message->setCreatedBy($user);
            $message->setCreatedAt(date('Y-m-d H:i:s'));
            $message->setEvent($event);

            return $this;
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/remove/message")
     * @Template()
     */
    public function removeAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/edit/message")
     * @Template()
     */
    public function editAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/delete/message")
     * @Template()
     */
    public function deleteAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/list/messages")
     * @Template()
     */
    public function listAction()
    {
        return array(
                // ...
        );
    }

}
