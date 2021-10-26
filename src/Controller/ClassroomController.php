<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    /**
     * @Route("/listeclass", name="listeclass")
     */
    public function  list()
    {
        $classrooms=$this->getDoctrine()->getRepository(Classroom::class)->findAll();
        return $this->render("classroom/list.html.twig",array('tabclass'=>$classrooms));

    }
    /**
     * @Route("/add", name="addClassroom")
     */

    public function add(\Symfony\Component\HttpFoundation\Request $request)
    {
        $Classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class,$Classroom);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Classroom);
            $em->flush();
            return $this->redirectToRoute("listeclass");

        }
        return $this->render("classroom/add.html.twig",array("formClassroom"=>$form->createView()));
    }
    /**
     * @Route("/update/{id}", name="updateClassroom")
     */

    public function update(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $Classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class,$Classroom);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("listeclass");

        }
        return $this->render("classroom/update.html.twig",array("formClassroom"=>$form->createView()));
    }
    /**
 * @Route("/delete/{id}", name="removeClassroom")
 */
    public function delete($id)
    {
        $Classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
   $em=$this->getDoctrine()->getManager();
   $em->remove($Classroom);
   $em->flush();
   return $this->redirectToRoute("listeclass");
    }
}
