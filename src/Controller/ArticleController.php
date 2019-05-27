<?php
/**
 * Created by PhpStorm.
 * User: syfea
 * Date: 10/05/19
 * Time: 14:25
 */

namespace App\Controller;


use App\Entity\Article;
use App\Service\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ArticleType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(Api $api): Response
    {
        $category = $api->getCategory();

        return $this->render('article/index.html.twig', [
            'articles' => $category->articles,
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $api = new Api();
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $api->postArticle($request->request->get('article'));

            return $this->redirectToRoute('article_edit', [
                'id' => $response->id,
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $api = new Api();
        $article = $api->getArticle($id);

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $api = new Api();

        $images = $api->getImages();

        $article = $api->getArticle($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $api->putArticle($request->request->get('article'), $id);

            return $this->redirectToRoute('article_index', [
                'id' => $id,
            ]);
        }

        $image = null;
        if ($article->image != null) {
            $image = $api->getImageUrl($article->image);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $api = new Api();
            $api->deleteArticle($id);
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/{id}/image", name="article_image", methods={"GET"})
     */
    public function image(Request $request, $id): Response
    {
        $api = new Api();
        $article = $api->getArticle($id);

        return new Response($api->getImageUrl($article->image));
    }
}
