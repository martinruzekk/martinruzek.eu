<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegistraionType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class SecurityController extends AbstractController
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private MailerInterface $mailer;

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
    }

    #[Route('/registration', name: 'registration')]
    public function registration(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $loginFormAuthenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistraionType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );


            $em->persist($user);
            $em->flush();

            $signature = $this->verifyEmailHelper->generateSignature(
                'registration_confirmation_route',
                $user->getId(),
                $user->getEmail()
            );

            $email = new TemplatedEmail();
            $email->from(new Address('verification@martinruzek.eu', 'MR Mail Bot'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context(['signedUrl' => $signature->getSignedUrl()]);

            $this->mailer->send($email);

            return $userAuthenticator->authenticateUser(
                $user,
                $loginFormAuthenticator,
                $request
            );
        }


        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify', name: 'registration_confirmation_route')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $userRepository->find($this->getUser()->getUserIdentifier());


        // Do not get the User's Id or Email Address from the Request object
        try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('verify_email_error', $e->getReason());

            return $this->redirectToRoute('app_register');
        }

        // Mark your user as verified. e.g. switch a User::verified property to true
        $user->setIsVerified(true);

        $this->addFlash('success', 'Your e-mail address has been verified.');

        return $this->redirectToRoute('login');
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        throw new \Exception('Logout should never be reached.');
    }
}
