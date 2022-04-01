<?php

namespace App\Controller\boutique;

use App\Controller\Controller;
use App\Entity\Product;
use App\Form\AddProductFormType;
use App\Handler\ProductFormHandler;
use App\Services\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller
{

    /**
     * @Route("/{_locale<%app.supported_locales%>}/boutique/add", name="app_addProd")
     *
     */

    public function addProd(Request $request, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(AddProductFormType::class, $product);
        $formHandler = (new ProductFormHandler($form, $request, $product, $this->entityManager, $fileUploader))->process();
        if ($formHandler) {
            return $this->redirectToRoute('app_boutique');
        }
        return $this->renderForm('boutique/addProduct.html.twig', [
            'formProduct' => $form
        ]);
    }

    /**
     * @Route("/boutique/{id<^[1-9]{1}[0-9]*$>}", name="app_prodDel")
     */
    public function deleteProd(Product $pro): Response
    {
        $this->entityManager->remove($pro);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_boutique');
    }
}

