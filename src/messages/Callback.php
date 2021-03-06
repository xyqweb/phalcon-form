<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 21:54
 */

namespace xyqWeb\form\messages;


class Callback extends ValidatorFactory
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
            $message['message'][$attribute]  = ($this->attributeLabels[$attribute]?? '') . $this->validator['message'];
            $message['callback'][$attribute] = $this->ruleItem[2]?? [];
        }
        return $message;
    }
}