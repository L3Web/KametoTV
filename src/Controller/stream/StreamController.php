<?php

namespace App\Controller\stream;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends AbstractController
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/stream", name="app_stream")
     *
     * @return Response
     */
    public function showStream()
    {

       return $this->render('/stream/stream.html.twig');
    }



}