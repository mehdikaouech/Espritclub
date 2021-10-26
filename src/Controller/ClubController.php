<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Student;
use App\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */

    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);

    }
    /**
     * @Route("/club/{var}",name="getClub")
     */

    public function getName($var)
    {
        $x = 10;
        return $this->render("club_esprit/club.html.twig", array("x" => $var, "var" => $x));
    }
    /**
     * @Route("/listeClub",name="listeClub")
     */
public function listeClub()
{
    $listeclub=$this->getDoctrine()->getRepository( Club::class)->findAll();
    return $this->render("club/listClub.html.twig",array("listclub"=> $listeclub ));
}
/**
 * @Route("/addClub",name="addClub")
 */
    public function addClub ( Request $request)
    {
        $Club= new Club();
        $form=$this->createForm(ClubType::class,$Club);
        $form->handleRequest($request);
     if($form->isSubmitted()){

         $em=$this->getDoctrine()->getManager();
         $em->persist($Club);
         $em->flush();
           return $this->redirectToRoute("listeClub");
     }
     return $this->render("club/addform.html.twig",array("formulaireAdd"=>$form ->createView()));
    }
    /**
     * @Route("/updateClub/{id}",name="updateClub")
     */
   public function updateClub( Request $Request ,$id){
       $club=$this->getDoctrine()->getRepository(Club::class)->find($id);
       $form=$this->createForm(ClubType::class,$club);
       $form->handleRequest($Request);
       if ($form->isSubmitted()){
           $em=$this->getDoctrine()->getManager();
           $em->flush();
           return$this->redirectToRoute("listeClub");

       }
       return $this->render("club/updateClub.html.twig" ,array("formulaireAdd"=>$form->createView()));




   }

    /**
     * @Route("/deleteClub/{id}", name="removeClub")
     */
    public function deleteClub($id)
    {
        $Club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Club);
        $em->flush();
        return $this->redirectToRoute("listeClub");
    }


}
