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

class MobileValidator extends Validator implements ValidatorInterface
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
        $prefixMobileAttribute = $this->getOption('with')[$attribute] ?? '';
        $value = $validation->getValue($attribute);
        if (empty($prefixMobileAttribute)) {
            $result = $this->validateChineseMobile($value);
        } else {
            $prefixMobile = $validation->getValue($prefixMobileAttribute);
            if (empty($prefixMobile) || '+86' == $prefixMobile || '86' == $prefixMobile) {
                $result = $this->validateChineseMobile($value);
            } else {
                $result = $this->validateForeignMobile($value);
            }
        }
        if (false == $result) {
            $message = $this->getOption('message');
            if (!$message) {
                $message = $attribute . ' is not valid phone number';
            } else {
                $message = $message[$attribute];
            }
            $validation->appendMessage(new Message($message, $attribute, 'Mobile'));
            return false;
        }
        return true;
    }

    /**
     * 校验国内手机号码
     *
     * @author xyq
     * @param $value
     * @return bool
     */
    private function validateChineseMobile($value)
    {
        if (!is_numeric($value) || !preg_match('/^1[3|4|5|6|7|8|9]\d{9}$/', $value)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 校验国际手机号码
     *
     * @author xyq
     * @param $value
     * @return bool
     */
    private function validateForeignMobile($value)
    {
        if (!is_numeric($value) || strlen($value) > 14 || strlen($value) < 4) {
            return false;
        } else {
            return true;
        }
    }
}