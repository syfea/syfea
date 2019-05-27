<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\Contact;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repository->findBy(array(), array('createdAt' => 'desc'));

        return $this->render('admin/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/admin/perso", name="admin_perso")
     */
    public function perso(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('admin/perso.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
