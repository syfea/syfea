<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 07/03/19
 * Time: 17:14
 */

namespace App\Controller;

use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Curl\Curl;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\User;
use App\Entity\Project;
use App\Entity\Service;
use App\Entity\Job;
use App\Entity\School;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ComplexObject;

class IndexController extends AbstractController
{
    /**
     *
     * @Route("/", name="index_index")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    public function header()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneByUsername(getenv('USER_NAME'));

        return $this->render('front/header.html.twig', [
            'user' => $user
        ]);
    }

    public function about()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneByUsername(getenv('USER_NAME'));

        return $this->render('front/about.html.twig', [
            'user' => $user
        ]);
    }

    public function work()
    {
        $repository = $this->getDoctrine()->getRepository(Project::class);
        $projects =  $repository->findBy(array(), array('date' => 'desc'));

        return $this->render('front/work.html.twig', [
            'projects' => $projects
        ]);
    }

    public function service()
    {
        $repository = $this->getDoctrine()->getRepository(Service::class);
        $services =  $repository->findBy(array(), array('name' => 'asc'));

        return $this->render('front/feature.html.twig', [
            'services' => $services
        ]);
    }

    public function resume()
    {
        $repository = $this->getDoctrine()->getRepository(Job::class);
        $jobs =  $repository->findBy(array(), array('position' => 'asc'));

        $repository = $this->getDoctrine()->getRepository(School::class);
        $schools =  $repository->findBy(array(), array('position' => 'asc'));

        return $this->render('front/resume.html.twig', [
            'jobs' => $jobs,
            'schools' => $schools
        ]);
    }

    public function hire()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneByUsername(getenv('USER_NAME'));

        return $this->render('front/hire.html.twig', [
            'user' => $user
        ]);
    }

    public function blog(Api $api)
    {
        $category = $api->getCategory();

        if (is_array($category->articles) && count($category->articles) == 0) {
            return new Response();
        }

        return $this->render('front/blog.html.twig', [
            'category' => $category,
            'api' => $api
        ]);
    }

    /**
     *
     * @Route("/article/{id}", name="index_article")
     */
    public function article(Request $request, $id)
    {


        return new Response();
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return mixed
     *
     * @Route("/contact", name="index_contact", condition="request.isXmlHttpRequest()")
     */

    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = "Message - Syfea";
            $message = (new \Swift_Message($subject))
                ->setFrom(getenv('MAILER_ADDRESS'))
                ->setTo(getenv('MAILER_ADDRESS_TO'))
                ->setBody(
                    $this->renderView(
                        'emails/message.html.twig',
                        ['mail' => $contact]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->get('session')->getFlashBag()->add('success', 'Votre message a bien été envoyé. Merci.');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('index_contact'));
        }

        return $this->render('front/contact.html.twig',
            ['form' => $form->createView()]
        );
    }
}