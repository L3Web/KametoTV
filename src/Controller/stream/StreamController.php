<?php

namespace App\Controller\stream;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends AbstractController
{
    #[Route('/stream', name: 'stream')]
    public function showStream()
    {

       return $this->render('/stream/stream.html.twig');
    }



}