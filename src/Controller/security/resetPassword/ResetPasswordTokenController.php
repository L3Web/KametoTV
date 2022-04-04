<?php

namespace App\Controller\security\resetPassword;

use App\Form\ChangePasswordFormType;
use App\Handler\ChangePasswordResetHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

class ResetPasswordTokenController extends ResetPasswordController
{
    use ResetPasswordControllerTrait;

    /**
     * @Route("/{_locale<%app.supported_locales%>}/reset/{token}", name="app_reset_password")
     *
     * Validates and process the reset URL that the user clicked in their email.
     */
    public function reset(Request $request, UserPasswordHasherInterface $userPasswordHasher, string $token = null): Response
    {
        if ($token) {
            // We store the token in session and remove it from the URL, to avoid the URL being
            // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
            $this->storeTokenInSession($token);

            return $this->redirectToRoute('app_reset_password');
        }

        $token = $this->getTokenFromSession();
        if (null === $token) {
            throw $this->createNotFoundException('No reset password token found in the URL or in the session.');
        }

        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        } catch (ResetPasswordExceptionInterface $e) {
            $this->addFlash('reset_password_error', sprintf(
                'There was a problem validating your reset request - %s',
                $e->getReason()
            ));

            return $this->redirectToRoute('app_forgot_password_request');
        }

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $formHandler = new ChangePasswordResetHandler($form, $request, $user, $userPasswordHasher, $this->entityManager);
        if ($formHandler->process()) {
            // A password reset token should be used only once, remove it.
            $this->resetPasswordHelper->removeResetRequest($token);

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }

}