<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class UserController extends Controller
{

    /**
     * @Route("/add/{id}", name="add_friend")
     */
    public function addFriendAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()
                ->getManager();

        $friend = $em->getRepository('AppBundle:User')
                ->findOneBy(['username' => $id]);
        
        $user->addMyFriend($friend);

        $em->flush();

        return $this->redirectToRoute('list_friends', [
        ]);
    }

    /**
     * @Route("/delete/friend/{id}", name="delete_friend")
     */
    public function deleteFriendAction(User $friend)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()
                ->getManager();

        $user->removeMyFriend($friend);

        $em->flush();

        return $this->redirectToRoute('list_friends', [
        ]);
    }

    /**
     * @Route("send/user/{id}", name="send_message_friend")
     */
    public function sendMessageAction($id)
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("search/user/", name="search_friend")
     */
    public function searchUsersAction(Request $request)
    {
        $user = $this->getUser();

        $friends = $user->getMyFriends();

        $ids = array();
        foreach ($friends as $w) {
            $ids[] = $w->getId();
        }

        $events = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->getFriendsEventQuery($friends);

        $data = $request->query->get('query');

        if ($data == '') {
            $this->addFlash('danger', 'Aby wyszukać znajomego, musisz wpisać jakąś frazę');
        } else {
            $getUsersQuery = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->searchUsersQuery($data);
        }

        return $this->render('User/list.html.twig', [
                    'searchUsers' => $getUsersQuery,
                    'friends' => $friends,
                    'events' => $events,
                    'ids' => $ids,
        ]);
    }

    /**
     * @Route("list/users/", name="list_friends")
     */
    public function listUserAction()
    {
        $user = $this->getUser();
        $friends = $user->getMyFriends();
        $hiddenFriends = $user->getHiddenFriends();

        $friendsIds = array();
        foreach ($friends as $w) {
            $friendsIds[] = $w->getId();
        }
        
        $events = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->getFriendsEventQuery($friends);

        $proposeFriends = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->getProposeFriends($user, $friendsIds, $hiddenFriends);

        return $this->render('User/list.html.twig', [
                    'friends' => $friends,
                    'searchUsers' => $proposeFriends,
                    'events' => $events,
                    'ids' => $friendsIds,
        ]);
    }

    /**
     * @Route("show/user/{id}", name="show_user")
     */
    public function showUserAction(User $user)
    {

        $events = $this->getDoctrine()
                ->getRepository('AppBundle:Event')
                ->getUserEvents($user);

        return $this->render('User/show.html.twig', [
                    'user' => $user,
                    'events' => $events,
        ]);
    }

    /**
     * @Route("hide/user/{id}", name="hide_user")
     */
    public function hideFriendAction(User $user)
    {
        $em = $this->getDoctrine()
                ->getManager();

        $admin = $this->getUser();

        $admin->addHiddenFriend($user);

        $em->flush();

        return $this->redirectToRoute('list_friends', [
        ]);
    }

}
