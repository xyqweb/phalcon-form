<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 21:51
 */

namespace xyqWeb\form\messages;


class Between extends ValidatorFactory
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
            $message['message'][$attribute] = ($this->attributeLabels[$attribute] ?? '') . $this->validator['message'];
            $between[]                      = $this->ruleItem['min'] ?? 0;
            $between []                     = $this->ruleItem['max'] ?? 0;
            $message['message'][$attribute] = vsprintf($message['message'][$attribute], $between);
            $message['minimum'][$attribute] = $between[0];
            $message['maximum'][$attribute] = $between[1];
        }
        return $message;
    }
}