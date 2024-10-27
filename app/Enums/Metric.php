<?php

namespace App\Enums;

enum Metric: string
{
    case LOGIN = 'auth.login';
    case LOGOUT = 'auth.logout';
    case REGISTER = 'auth.register';
    case PASSWORD_RESET = 'auth.password_reset';
    case EMAIL_VERIFIED = 'auth.email_verified';
}
