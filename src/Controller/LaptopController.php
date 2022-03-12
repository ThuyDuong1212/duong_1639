<?php

namespace App\Controller;

use App\Entity\Laptop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/laptop')]
class LaptopController extends AbstractController
{
    #[Route('', methods:'GET' , name: 'laptop_index')]
    public function laptopIndex() {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->findAll();
        return $this->render("laptop/index.html.twig",
        [
            'laptops' => $laptop
        ]);
    }

    #[Route('/detail/{id}', name: 'laptop_detail')]
    public function laptopDetail($id) {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        return $this->render("laptop/detail.html.twig",
        [
            'laptop' => $laptop
        ]);
    }

    #[Route('/delete/{id}', name: 'laptop_delete')]
    public function laptopDelete($id) {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        //kiểm tra nếu không có movie nào thuộc laptop này thì cho phép xóa
        if (count($laptop->getMovies()) == 0) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($laptop);
            $manager->flush();
        }

        return $this->redirectToRoute("laptop_index");
    }

    #[Route('/add', name: 'laptop_add')]
    public function laptopAdd(Request $request) {
        $laptop = new Laptop;
        $form = $this->createForm(laptopType::class,$laptop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($laptop);
            $manager->flush();
            return $this->redirectToRoute("laptop_index");
        }
        return $this->renderForm("laptop/add.html.twig",
        [
            'form' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'laptop_edit')]
    public function laptopEdit(Request $request, $id) 
    {
        $laptop = $this->getDoctrine()->getRepository(Laptop::class)->find($id);
        $form = $this->createForm(laptopType::class,$laptop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($laptop);
            $manager->flush();
            return $this->redirectToRoute("laptop_index");
        }
        return $this->renderForm("laptop/edit.html.twig",
        [
            'form' => $form
        ]);
    }
    

}
