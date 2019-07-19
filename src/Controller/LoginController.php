<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
     /**
     * @Route("/")
     */
    public function index()
    {
       return $this->render('login/login.html.twig');
    }
    /**
     * @Route("/login", name="login")
     */
  
    public function login(Request $request)
    {
               
           
                $nom=$request->request->get('user');
                $password=$request->request->get('password');
         

                $NBR= $this->getDoctrine()->getRepository(Users::class)->countById($nom,$password);;
                
               
                $nombre=(int)$NBR[0]['nbr'];
                if($nombre==1){
                    $users= $this->getDoctrine()->getRepository(Users::class)->findAll();
                    return $this->render('login/admin.html.twig',array('users' => $users));
                }
                else{
                    return $this->render('login/login.html.twig');
                }
               
                
                
    }
    /**
     * @Route("/update", name="update")
     */
    public function update(Request $request)
    {
               
                $id=$request->request->get('id');
                $nom=$request->request->get('nom');
                $password=$request->request->get('password');
         
                $this->getDoctrine()->getRepository(Users::class)->update($nom,$password,$id);;
                $users= $this->getDoctrine()->getRepository(Users::class)->findAll();
                return $this->render('login/admin.html.twig',array('users' => $users));
               
                
                
    }
       /**
     * @Route("/delete", name="delete")
     */
    public function delete(Request $request)
    {
               
                $id=$request->request->get('id');
         
                $this->getDoctrine()->getRepository(Users::class)->delete($id);
                $users= $this->getDoctrine()->getRepository(Users::class)->findAll();
                return $this->render('login/admin.html.twig',array('users' => $users));
               
                
                
    }

}
