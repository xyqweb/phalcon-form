<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2020-04-11
 * Time: 20:08
 */

namespace xyqWeb\form\validators;


use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;
use Phalcon\Validation\ValidatorInterface;

class MobilePrefixValidator extends Validator implements ValidatorInterface
{
    /**
     * 验证手机号码
     *
     * @author xyq
     * @param \Phalcon\Validation $validation
     * @param string $attribute
     * @return bool
     */
    public function validate(Validation $validation, $attribute)
    {
        $value = $validation->getValue($attribute);
        if (!is_numeric($value) || !preg_match('/^\+[1,9]{1}|\+\d{1,4}$/', $value)) {
            $message = $this->getOption('message');
            if (!$message) {
                $message = $attribute . ' is not valid phone number prefix';
            } else {
                $message = $message[$attribute];
            }
            $validation->appendMessage(new Message($message, $attribute, 'MobilePrefix'));
            return false;
        }
        return true;
    }
}