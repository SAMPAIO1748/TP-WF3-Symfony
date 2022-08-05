<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    
    /**
     * @Route("books", name="books_list")
     */
    public function bookList(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render("books_list.html.twig", ['books' => $books]);
    }

    /**
     * @Route("book/{id}", name="book_show")
     */
    public function bookShow($id, BookRepository $bookRepository)
    {
        $book = $bookRepository->find($id);

        return $this->render("book_show.html.twig", ['book' => $book]);
    }

    /**
     * @Route("update/book/{id}", name="book_update")
     */
    public function bookUpdate(
        $id, 
        BookRepository $bookRepository, 
        EntityManagerInterface $entityManagerInterface, 
        Request $request)
    {
        $book = $bookRepository->find($id);

        $bookForm = $this->createForm(BookType::class, $book);

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            
            $entityManagerInterface->persist($book);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("books_list");

        }

        return $this->render("book_form.html.twig", ['bookForm' => $bookForm->createView()]);
    }

    /**
     * @Route("create/book", name="book_create")
     */
    public function bookCreate(
        EntityManagerInterface $entityManagerInterface, 
        Request $request
    )
    {
        $book = new Book();

        $bookForm = $this->createForm(BookType::class, $book);

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            
            $entityManagerInterface->persist($book);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("books_list");

        }

        return $this->render("book_form.html.twig", ['bookForm' => $bookForm->createView()]);
    }

    /**
     * @Route("delete/book/{id}", name="book_delete")
     */
    public function deleteBook(
        $id,
        BookRepository $bookRepository, 
        EntityManagerInterface $entityManagerInterface
    )
    {
        $book = $bookRepository->find($id);

        $entityManagerInterface->remove($book);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("books_list");
    }

}
