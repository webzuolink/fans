<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Http\Request;
use Overtrue\EasySms\PhoneNumber;
use App\Sms\Utils\TextVerificationCode;
use Illuminate\Contracts\Validation\Rule;

class VerifyPhoneTextVerificationCode implements Rule
{
    /**
     * The validate phone number.
     */
    protected $phoneNumber;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request, string $phoneNumberField = 'phone', string $TTC = 'international_telephone_code')
    {
        $this->phoneNumber = (string) (new PhoneNumber($request->{$phoneNumberField}, $request->{$TTC}));
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
        return TextVerificationCode::validate($this->phoneNumber, (int) $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('你输入的验证码错误');
    }
}
