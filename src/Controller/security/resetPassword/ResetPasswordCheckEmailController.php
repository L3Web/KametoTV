<?php

namespace App\Controller\security\resetPassword;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ResetPasswordCheckEmailController extends ResetPasswordController
{
    use ResetPasswordControllerTrait;
    /**
     * @Route("/{_locale<%app.supported_locales%>}/check-email", name="app_check_email")
     *
     * Confirmation page after a user has requested a password reset.
     */
    public function checkEmail(ResetPasswordHelperInterface $resetPasswordHelper): Response
    {
        // Generate a fake token if the user does not exist or someone hit this page directly.
        // This prevents exposing whether or not a user was found with the given email address or not
        if (null === ($resetToken = $this->getTokenObjectFromSession())) {
            $resetToken = $resetPasswordHelper->generateFakeResetToken();
        }

        return $this->render('security/reset_password/check_email.html.twig', [
            'resetToken' => $resetToken,
        ]);
    }

}