<?php

namespace App\Controller;

use App\Entity\Riddle;
use App\Entity\Score;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\SubmitFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class SubmitController extends AbstractController
{
    #[Route('/submit/{id}', name: 'app_submit')]
    #[IsGranted("ROLE_USER")]
    public function submit(Riddle $riddle, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubmitFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedAnswer = $form->get("answer")->getData();

            if($submittedAnswer !== $riddle->getToken()) {
                $this->addFlash("fail", "Wrong answer!");
            } else {

                /** @var User $user */
                $user = $this->getUser();

                $score = new Score();
                $score->setRiddle($riddle)
                    ->setScore($riddle->getDifficulty())
                    ->setSolvedAt(new \DateTimeImmutable())
                    ->setUser($user);

                $user->addScoreRiddle($riddle);

                $entityManager->persist($score);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash("success", "Good job, you earned {$score->getScore()} point". $score->getScore() > 1 ? "s" : "" . "!");
                return $this->redirectToRoute("app_home");
            }
        }

        return $this->render('submit/index.html.twig', [
            'submitForm' => $form->createView(),
        ]);
    }
}
