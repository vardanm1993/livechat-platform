<?php

declare(strict_types=1);

namespace App\Enums;

enum SecurityEventType: string
{
    case UserRegistered = 'user_registered';
    case UserLoggedIn = 'user_logged_in';
    case UserLoggedOut = 'user_logged_out';
    case EmailVerified = 'email_verified';
    case PasswordResetCompleted = 'password_reset_completed';
}
