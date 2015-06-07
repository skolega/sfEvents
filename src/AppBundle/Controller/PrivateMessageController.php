<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PrivateMessage;
use AppBundle\Form\PrivateMessageType;
use AppBundle\Entity\User;

class PrivateMessageController extends Controller
{

    /**
     * @Route("/new/privatemessage/{id}", name="new_private_message")
     */
    public function newAction(User $recipient, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sender = $this->getUser();

        $privateMessage = new PrivateMessage();

        $form = $this->createForm(new PrivateMessageType(), $privateMessage);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $privateMessage->setCreatedBy($sender);
            $privateMessage->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $privateMessage->setSendTo($recipient);
            $em->persist($privateMessage);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('PrivateMessage/new.html.twig', array(
                    'form' => $form->createView(),
                    'id' => $recipient->getId(),
        ));
    }

    /**
     * @Route("/remove/privatemessage")
     * @Template()
     */
    public function removeAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("reply/privatemessage")
     * @Template()
     */
    public function replyAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/show/privatemessage")
     * @Template()
     */
    public function showAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/list/privatemessage")
     */
    public function listAction()
    {
        $user = $this->getUser();

        $messages = $this->getDoctrine()
                ->getRepository('AppBundle:PrivateMessage')
                ->findBy(['sendTo' => $user], ['createdAt' => 'DESC'], 4);

        return $this->render('PrivateMessage/list.html.twig', [
                    'messages' => $messages,
        ]);
    }

    /**
     * @Route("/hide/privatemessage", name="hide_private_messages")
     */
    public function hideAction()
    {
        $user = $this->getUser();

        $messages = $this->getDoctrine()
                ->getRepository('AppBundle:PrivateMessage')
                ->findBy(['sendTo' => $user]);

        $em = $this->getDoctrine()->getManager();
        foreach ($messages as $message) {
            $message->setReaded(true);
        }
        $em->flush();

        return $this;
    }

    private function getRefererParams()
    {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $request->getBaseUrl();
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
        return $this->get('router')->getMatcher()->match($lastPath);
    }

    public function handleRequestAction()
    {

        $request = $this->get('request');
    }

}
