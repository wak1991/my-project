<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('/default.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/product/{slug}")
     */
    public function product($slug)
    {
        $slug = ['slug' => $slug];
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy($slug);

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $categoryName = $product->getCategory()->getName();
        $categorySlug = $product->getCategory()->getSlug();

        return $this->render('/product.html.twig', [
            'product' => $product,
            'categoryName' => $categoryName,
            'categories' => $categories,
            'categorySlug' => $categorySlug,
        ]);
    }

    /**
     * @Route("/category/{slug}", name="category")
     */
    public function category($slug)
    {
        $slug = ['slug' => $slug];
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy($slug);

        $products = $category->getProducts();

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'category' => $category,
        ]);
    }

}