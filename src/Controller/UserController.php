<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\User;
use App\Form\Type\UserType;

/**
 *UserController.
 *@Route("/user", name="user")
 */
class UserController extends Controller
{

    /**
     * @Route("/new", name="user_new")
     * @Method({"POST", "PUT"})
     */
    public function newAction(Request $request)
    {
        return $this->addAction($request);
    }

    /**
     * @Route("/add/{email}/{password}", name="user_add")
     * @Method({"POST", "PUT"})
     */
    public function addAction(Request $request)
    {
        if ($request->get('email') !== null && $request->get('password') !== null) {
            $response = $this->loginAction($request);
            if ((int) $response->getStatusCode() !== 200) {
                return new JsonResponse(['authentication' => false, 'message' => 'Username or Password not valid.'], Response::HTTP_UNAUTHORIZED);
            }
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
        $form->handleRequest($request);
        $data = json_decode($request->getContent(), true);
        if (null !== $data) {
            $form->submit($data);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setEmail($data->getEmail());
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $data->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $user = $this->container->get('doctrine')->getRepository(User::class)->insert($user);
            if ($user !== null && $user instanceof User) {
                return new JsonResponse(['add' => true, 'is_submitted' => $form->isSubmitted(), 'is_valid' => $form->isValid()], Response::HTTP_OK);
            }
        }
        return new JsonResponse(['add' => false, 'is_submited' => $form->isSubmitted(), 'is_valid' => false, 'errors' => (string) $form->getErrors(true, false)], Response::HTTP_OK);
    }

    /**
     * @Route("/delete/{id}/{email}/{password}", name="user_delete")
     * @Method({"POST", "DELETE"})
     */
    public function deleteAction(Request $request)
    {
        $response = $this->loginAction($request);
        if ((int) $response->getStatusCode() !== 200) {
            return new JsonResponse(['authentication' => false, 'message' => 'Username or Password not valid.'], Response::HTTP_UNAUTHORIZED);
        }
        $user = $this->container->get('doctrine')->getRepository(User::class)->findOneUserById($request->get('id'));
        if (null != $user && $user instanceof User) {
            $this->container->get('doctrine')->getRepository(User::class)->delete($user);
            return new JsonResponse(['delete' => true, 'message' => 'User delete ok.'], Response::HTTP_OK);
        }
        return new JsonResponse(['delete' => false, 'message' => 'User not found.'], Response::HTTP_OK);
    }

    /**
     * @Route("/login/{email}/{password}", name="user_login")
     * @Method({"POST", "PUT"})
     */
    public function loginAction(Request $request)
    {
        $user = $this->container->get('doctrine')->getRepository(User::class)->findOneUserByEmail($request->get('email'));
        if (null != $user && $user instanceof User) {
            $password_encoder = $this->get('security.password_encoder');
            if ($password_encoder->isPasswordValid($user, $request->get('password'), $user->getSalt())) {
                return new JsonResponse(['login' => true, 'message' => 'Authentication ok.'], Response::HTTP_OK);
            }
        }
        return new JsonResponse(['login' => false, 'message' => 'Username or Password not valid.'], Response::HTTP_UNAUTHORIZED);
    }

}
