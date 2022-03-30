<?php

namespace App\Controller\videos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideosController extends AbstractController
{
    /**
    * @Route("/{_locale<%app.supported_locales%>}/videos", name="app_videos")
    */
    public function showVideos(): Response
    {
        $res = file_get_contents("https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UCiRDO4sVx9dsyMm9F7eWMvw&maxResults=10&order=date&key=AIzaSyDI6w0X2xT8WpRBOX8DJsjZxkN9w9Agfmg");
        $videoArray  = (json_decode($res, true))["items"];
        $videoRes=array();
        $titleRes=array();

        foreach ($videoArray as $value) {
            $videoRes[] = $value["id"]["videoId"];
            $titleRes[] = htmlspecialchars_decode($value["snippet"]["title"], ENT_QUOTES);
        }

       return $this->render('/videos/videos.html.twig', [
           "videoId"=>$videoRes,
           "titleId"=>$titleRes
       ]);
    }



}