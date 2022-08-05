<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{

    /**
     * @Route("genres", name="genres_list")
     */
    public function genreList(GenreRepository $genreRepository)
    {
        $genres = $genreRepository->findAll();

        return $this->render("genres_list.html.twig", ['genres' => $genres]);
    }

    /**
     * @Route("genre/{id}", name="genre_show")
     */
    public function genreShow($id, GenreRepository $genreRepository)
    {
        $genre = $genreRepository->find($id);

        return $this->render("genre_show.html.twig", ['genre' => $genre]);
    }

    /**
     * @Route("update/genre/{id}", name="genre_update")
     */
    public function genreUpdate(
        $id, 
        GenreRepository $genreRepository, 
        EntityManagerInterface $entityManagerInterface, 
        Request $request)
    {
        $genre = $genreRepository->find($id);

        $genreForm = $this->createForm(GenreType::class, $genre);

        $genreForm->handleRequest($request);

        if ($genreForm->isSubmitted() && $genreForm->isValid()) {
            
            $entityManagerInterface->persist($genre);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("genres_list");

        }

        return $this->render("genre_form.html.twig", ['genreForm' => $genreForm->createView()]);
    }

    /**
     * @Route("create/genre", name="genre_create")
     */
    public function genreCreate(
        EntityManagerInterface $entityManagerInterface, 
        Request $request
    )
    {
        $genre = new Genre();

        $genreForm = $this->createForm(GenreType::class, $genre);

        $genreForm->handleRequest($request);

        if ($genreForm->isSubmitted() && $genreForm->isValid()) {
            
            $entityManagerInterface->persist($genre);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("genres_list");

        }

        return $this->render("genre_form.html.twig", ['genreForm' => $genreForm->createView()]);
    }

    /**
     * @Route("delete/genre/{id}", name="genre_delete")
     */
    public function deleteGenre(
        $id,
        GenreRepository $genreRepository, 
        EntityManagerInterface $entityManagerInterface
    )
    {
        $genre = $genreRepository->find($id);

        $entityManagerInterface->remove($genre);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("genres_list");
    }
   
}
