<?php


namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class BookController extends AbstractFOSRestController
{
    public $bookRepository;

    
    /**
     * @Rest\Get("/books", name="books",methods={"GET"})
     */
    public function index(Request $request,BookRepository $bookRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $page = $data['page'] ?? 1;
        $pageSize = $data['pageSize'] ?? 10;

        $filter = $data['filter'];
        if(!array_key_exists('author', $filter)) $filter['author'] = '';

        if(empty($page)) $page = 1;
        if(empty($pageSize)) $pageSize = 10;

        $pagination = $bookRepository->getList($page, $pageSize, $filter['author']);
        $booksData = [];

        foreach ($pagination->getResult() as $book) {
            $booksData[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'price' => $book->getPrice(),
                'description' => $book->getDescription(),
            ];
        }

        $booksData['pageSize'] = $pagination->getPageSize();
        $booksData['previousPage'] = $pagination->getPreviousPage();
        $booksData['currentPage'] = $pagination->getCurrentPage();
        $booksData['nextPage'] = $pagination->getNextPage();
        $booksData['lastPage'] = $pagination->getTotalPages();
        $booksData['totalPages'] = $pagination->getTotalPages();
        
        return $this->json($booksData);
    }
    

    /**
     * @Rest\Get("/book/{id}", name="bookById",methods={"GET"})
     */
    public function getById(Request $request, BookRepository $bookRepository): JsonResponse
    {
        $id = $request->attributes->get('id');
        $book = $bookRepository->find($id);

        if (!$book) {
            return new JsonResponse(['error' => 'Object does not exist'], 400);
        }

        $booksData = [];

        $booksData[] = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'price' => $book->getPrice(),
            'description' => $book->getDescription(),
        ];

        return $this->json($booksData);
    }


    /**
     * @Rest\Get("/book/create", name="create",methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (empty($data['title']) || empty($data['price'])) {
            return new JsonResponse(['error' => 'The price and title should not be empty'], 400);
        }

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setDescription($data['description']);

        if (isset($data['price'])) {
            $book->setPrice($data['price']);
        }

        $entityManager->persist($book);
        $entityManager->flush();

        $booksData = [];

        $booksData[] = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'price' => $book->getPrice(),
            'description' => $book->getDescription(),
        ];

        return $this->json($booksData);
    }


    /**
     * @Rest\Put("/book/edit/{id}", name="create_edit",methods={"PUT"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, BookRepository $bookRepository): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $id = $request->attributes->get('id');
        $book = $bookRepository->find($id);

        if (isset($data['title'])) {
            $book->setTitle($data['title']);
        }

        if (isset($data['author'])) {
            $book->setAuthor($data['author']);
        }

        if (isset($data['description'])) {
            $book->setDescription($data['description']);
        }

        if (isset($data['price'])) {
            $book->setPrice($data['price']);
        }

        $entityManager->persist($book);
        $entityManager->flush();

        $booksData = [];

        $booksData[] = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'price' => $book->getPrice(),
            'description' => $book->getDescription(),
        ];

        return $this->json($booksData);
    }

    /**
     * @Rest\Delete("/book/{id}", name="delete", methods={"DELETE"})
     *
     */
    public function delete(Request $request, EntityManagerInterface $entityManager, BookRepository $bookRepository): JsonResponse
    {
        $id = $request->attributes->get('id');
        $book = $bookRepository->find($id);

        if (!$book) {
            return new JsonResponse(['error' => 'Book not found'], 404);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Book deleted successfully'], 200);
    }
}
