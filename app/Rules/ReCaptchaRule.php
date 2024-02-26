<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class ReCaptchaRule implements Rule
{
    private $errorMsg;

    private $action;

    /**
     * Create a new rule instance.
     *
     * @param $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            $this->errorMsg = ':attribute field is required.';
            return false;
        }

        $recaptcha = new ReCaptcha(config('captcha.secret'));
        $resp = $recaptcha->setExpectedHostname(config('captcha.host_server'))
            ->setScoreThreshold(config('captcha.score'))
            ->setExpectedAction($this->action)
            ->verify($value, request()->getClientIp());
        if (!$resp->isSuccess()) {
            $this->errorMsg = 'ReCaptcha field is required.';

            return false;
        }

        if ($resp->getScore() < config('captcha.score')) {
            $this->errorMsg = 'Failed to validate captcha.';

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMsg;
    }
}
