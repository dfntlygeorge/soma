<?php

namespace App\Helpers;

class OnboardingHelper
{
    public static function field($name, $user, $onboarded)
    {
        // priority: old input > database > session
        return old($name) ?? (($onboarded ? $user->{$name} : session("onboarding.{$name}")) ?? '');
    }
}
