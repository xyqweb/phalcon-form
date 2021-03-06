<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019-04-10
 * Time: 19:24
 */

namespace xyqWeb\form\messages;


class Mobile extends ValidatorFactory
{

    /**
     * 获取组装后的消息
     *
     * @author xyq
     * @return array
     */
    public function getMessage() : array
    {
        $message = [];
        foreach ($this->ruleItem[0] as $attribute) {
            $message['with'][$attribute]    = $this->ruleItem[2] ?? '';
            $message['message'][$attribute] = ($this->attributeLabels[$attribute]?? '') . $this->validator['message'];
        }
        return $message;
    }
}