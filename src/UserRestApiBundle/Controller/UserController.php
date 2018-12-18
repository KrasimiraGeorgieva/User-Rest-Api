<?php

namespace UserRestApiBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @package UserRestApiBundle\Controller
 * @Route("/v1")
 */
class UserController extends Controller
{
    /**
     * http://domain.com/api/v1/users
     *
     * @Route("/users", name="rest_api_get_users", methods={"GET"})
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($users, 'json');

        return new Response(
            $json,
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }

    /**
     * http://domain.com/api/v1/users/1
     *
     * @Route("/users/{id}", name="rest_api_get_user", methods={"GET"}, requirements={"id": "\d+"})
     * @param $id
     * @return JsonResponse|Response
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (null === $user) {
            return new Response(
                json_encode(['error' => 'resource not found']),
                Response::HTTP_NOT_FOUND,
                array('content-type' => 'application/json'));
        }

        $serializer = $this->container->get('jms_serializer');
        $userJson = $serializer->serialize($user, 'json');

        return new Response(
            $userJson,
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );
    }

    /**
     * http://domain.com/api/v1/users
     *
     * @Route("/users", name="rest_api_create_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function createUserAction(Request $request)
    {
        try {
            //process submitted data
            $this->createNewUser($request);
            return new Response(null, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'application/json')
            );
        }
    }

    /**
     * http://domain.com/api/v1/users/1
     * @Route("/users/{id}", name="rest_api_user_edit", methods={"PUT"}, requirements={"id": "\d+"})
     * @param $request Request
     * @param $id User id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);

            if (null === $user) {
                $this->createNewUser($request);
                $statusCode = Response::HTTP_CREATED;
            } else {
                //update existing user
                $this->processForm($user, $request->request->all(),
                    'PUT');
                $statusCode = Response::HTTP_NO_CONTENT;
            }

            return new Response(null, $statusCode);
        } catch (\Exception $e) {
            return new Response(json_encode(array('error' => $e->getMessage())),
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'application/json')
            );
        }
    }

    /**
     * @Route("/users/{id}", name="rest_api_user_delete", methods={"DELETE"}, requirements={"id": "\d+"})
     * @param $request Request
     * @param $id
     * @return Response
     */
    public function deleteAction(Request $request, int $id)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->find($id);

            if (null === $user) {
                $statusCode = Response::HTTP_NOT_FOUND;
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                $statusCode = Response::HTTP_NO_CONTENT;
            }

            return new Response(null, $statusCode);

        } catch (\Exception $e) {

            return new Response(json_encode(['error' => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                array('content-type' => 'application/json')
            );
        }
    }

    /**
     * Creates new user from request parameters and persists it
     *
     * @param Request $request
     * @return User|array|string
     * @throws \Exception
     */
    protected function createNewUser(Request $request)
    {
        $user = new User();
        $parameters = $request->request->all();

        return $this->processForm($user, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param $user
     * @param $params
     * @param string $method
     * @return array|string
     * @throws \Exception
     */
    private function processForm($user, $params, $method = 'PUT')
    {
        foreach ($params as $param => $paramValue) {

            if (null === $paramValue || trim($paramValue) === '') {

                throw new \Exception("invalid data: $param");
            }
        }

        if (null === $user) {
            throw new \Exception('Invalid user id');
        }

        $form = $this->createForm(UserType::class, $user, ['method' => $method]);
        $form->submit($params);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new Response(json_encode($user), Response::HTTP_CREATED);
        }
        throw new \Exception('Submitted data is invalid');
    }
}
