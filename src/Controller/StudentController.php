<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Persistence\ObjectRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @var ObjectManger
     */
    private $em;

    /**
     * @Route("/student", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    public function __construct( ObjectRepository $repository, ObjectManger $em)
{
$this->$repository =$repository;
    $this->em = $em;
}
    /**
     * @Route("/listeStudent", name="listeStudent")
     */
    public function listStudents()
    {
        $listStudent = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render("student/listStudent.html.twig", array('students' => $listStudent));

    }

    /**
     * @Route("/addStudent", name="addStudent")
     */

    public function addStudent(\Symfony\Component\HttpFoundation\Request $request)
    {
        $Student = new Student();
        $form = $this->createForm(StudentType::class, $Student);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Student);
            $em->flush();
            return $this->redirectToRoute("listeStudent");

        }
        return $this->render("student/addStudent.html.twig", array("formStudent" => $form->createView()));


    }

    /**
     * @Route("/updateStudent/{id}", name="updateStudent")
     */
    public function updateStudent(\Symfony\Component\HttpFoundation\Request $request,$id)
    {
        $Student = $this->getDoctrine()->getRepository(Student::class )->find($id);
        $form = $this->createForm(StudentType::class, $Student);
$form->handleRequest($request);
if ($form->isSubmitted()){
    $em=$this->getDoctrine()->getManager();
    $em->flush();
    return$this->redirectToRoute("listeStudent");

}
return $this->render("student/updateStudent.html.twig",array("formStudent"=>$form->createView()));

    }
    /**
     * @Route("/deleteStudent/{id}", name="removeStudent")
     */
    public function deleteStudent($id): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $Student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Student);
        $em->flush();
        return $this->redirectToRoute("listeStudent");
    }
}