<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 21:45
 */

namespace xyqWeb\form\messages;


class In extends ValidatorFactory
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
            $message['message'][$attribute] = ($this->attributeLabels[$attribute]?? '') . sprintf($this->validator['message'], implode(',', $this->ruleItem[2]));
            $message['domain'][$attribute]  = $this->ruleItem[2]?? [];
        }
        return $message;
    }
}