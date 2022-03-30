<?php

namespace App\Controller\security\resetPassword;

use App\Controller\Controller;
use App\Entity\User;
use App\Form\ResetPasswordRequestFormType;
use App\Handler\SendingPasswordResetEmailController;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ResetPasswordController extends Controller
{
    use ResetPasswordControllerTrait;

    protected ResetPasswordHelperInterface $resetPasswordHelper;
    protected MailerService $mailerService;

    #[Pure] public function __construct(ResetPasswordHelperInterface $resetPasswordHelper, EntityManagerInterface $entityManager, MailerService $mailerService)
    {
        parent::__construct($entityManager);
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->mailerService = $mailerService;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/reset-password", name="app_forgot_password_request")
     *
     * Display & process form to request a password reset.
     * @throws TransportExceptionInterface
     */
    public function request(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $formHandler = (new SendingPasswordResetEmailController($request, $form))->process();

        if ($formHandler !== false) {
            return $this->processSendingPasswordResetEmail(
                $formHandler["email"],
                $formHandler["username"]
            );
        }

        return $this->render('security/reset_password/request.html.twig', [
            'requestForm' => $form->createView(),
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function processSendingPasswordResetEmail(string $emailFormData, string $usernameFormData): RedirectResponse
    {
        $user = $this->entityManager->getRepository(User::class)->findByUsernameMail($usernameFormData, $emailFormData);
        if ($user === null) {
            throw $this->createNotFoundException("User don't exist");
        }
        // Do not reveal whether a user account was found or not.
        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));

            return $this->redirectToRoute('app_check_email');
        }

        $this->mailerService->sendEmail("Your password reset request", $user->getEmail(), 'security/reset_password/email.html.twig', ["resetToken" => $resetToken]);

        // Store the token object in session for retrieval in check-email route.
        $this->setTokenObjectInSession($resetToken);

        return $this->redirectToRoute('app_check_email');
    }
}
