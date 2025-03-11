<?php

namespace App\Rules;
use ReCaptcha\ReCaptcha;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Captcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }

    public function passes($attribute, $value)
    {
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }

    public function message()
    {
        return 'Please complete the recaptcha to submit the form.';	//trả về thông báo khi lỗi không xác nhận captcha
    }

}
