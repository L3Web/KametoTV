<?php

namespace App\DataFixtures;

use App\Entity\Faq;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FaqFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faqs = [
            1 => [
                'question' => 'Quel âge as-tu ?',
                'answer' => 'J\'ai 26 ans'
            ],
            2 => [
                'question' => 'Quel est mon jeux favori ?',
                'answer' => 'League of Legends'
            ],
            3 => [
                'question' => 'Pourquoi le pseudo Kameto ?',
                'answer' => 'C\'est le surnom qu\'on donnait à mon grand père et je l\'ai repris'
            ],
            4 => [
                'question' => 'Quelles sont tes futurs projets ?',
                'answer' => 'Aller en LEC et gagner les World'
            ],
        ];

        foreach ($faqs as $key => $value ) {
            $faq = new Faq();
            $faq->setQuestion($value['question']);
            $faq->setAnswer($value['answer']);
            $manager->persist($faq);
    }
        $manager->flush();
    }
}
