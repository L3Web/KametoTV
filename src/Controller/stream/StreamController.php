<?php

namespace App\Controller\stream;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StreamController extends AbstractController
{
    #[Route('/stream', name: 'stream')]
    public function showStream()
    {
        $res = file_get_contents("https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UCiRDO4sVx9dsyMm9F7eWMvw&maxResults=10&order=date&key=AIzaSyDI6w0X2xT8WpRBOX8DJsjZxkN9w9Agfmg");
        $array  = (json_decode($res, true));
        $array = $array["items"]["0"]["id"];
        foreach ($array as $video) {
            echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video["videoId"] . ' 
                "frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>

            </iframe>';

        }
       return $this->render('/stream/stream.html.twig');
    }



}