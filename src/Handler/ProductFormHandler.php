<?php

namespace App\Handler;

use App\Entity\Product;
use App\Services\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ProductFormHandler
{
    private Form $form;
    private Request $request;
    private Product $product;
    private EntityManagerInterface $entityManager;
    private FileUploaderService $fileUploader;

    public function __construct(Form $form, Request $request, Product $product, EntityManagerInterface $entityManager, FileUploaderService $fileUploader)
    {
        $this->form = $form;
        $this->request = $request;
        $this->product = $product;
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    public function process(): bool
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            $imageFile = $this->form->get('image')->getData();

            if ($imageFile) {
                $newFilename = $this->fileUploader->upload($imageFile);
                $this->product->setImage($newFilename);
            }
            $this->entityManager->persist($this->product);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}