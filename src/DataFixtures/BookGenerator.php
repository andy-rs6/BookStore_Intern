<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookGenerator extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $batchSize = 1000;

        for ($i = 1; $i <= 1000000; $i++) {
            $book = new Book();
            $book->setTitle("Book $i");
            $book->setAuthor("Author $i");
            $book->setDescription("Description for Book $i");
            $book->setPrice(mt_rand(10, 100));

            $manager->persist($book);

            // Flush and clear the entity manager every batch
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        // Flush any remaining entities
        $manager->flush();
    }
}
