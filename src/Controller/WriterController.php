<?php

namespace App\Controller;

use App\Entity\Writer;
use App\Form\WriterType;
use App\Repository\WriterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WriterController extends AbstractController
{
 /**
     * @Route("writers", name="writers_list")
     */
    public function writerList(WriterRepository $writerRepository)
    {
        $writers = $writerRepository->findAll();

        return $this->render("writers_list.html.twig", ['writers' => $writers]);
    }

    /**
     * @Route("writer/{id}", name="writer_show")
     */
    public function writerShow($id, WriterRepository $writerRepository)
    {
        $writer = $writerRepository->find($id);

        return $this->render("writer_show.html.twig", ['writer' => $writer]);
    }

    /**
     * @Route("update/writer/{id}", name="writer_update")
     */
    public function writerUpdate(
        $id, 
        WriterRepository $writerRepository, 
        EntityManagerInterface $entityManagerInterface, 
        Request $request)
    {
        $writer = $writerRepository->find($id);

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {
            
            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("writers_list");

        }

        return $this->render("writer_form.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    /**
     * @Route("create/writer", name="writer_create")
     */
    public function writerCreate(
        EntityManagerInterface $entityManagerInterface, 
        Request $request
    )
    {
        $writer = new Writer();

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {
            
            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("writers_list");

        }

        return $this->render("writer_form.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    /**
     * @Route("delete/writer/{id}", name="writer_delete")
     */
    public function deleteWriter(
        $id,
        WriterRepository $writerRepository, 
        EntityManagerInterface $entityManagerInterface
    )
    {
        $writer = $writerRepository->find($id);

        $entityManagerInterface->remove($writer);
        $entityManagerInterface->flush();

        return $this->redirectToRoute("writers_list");
    }
}
