<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 21:46
 */

namespace xyqWeb\form\messages;


class Length extends ValidatorFactory
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
            $message['message'][$attribute] = ($this->attributeLabels[$attribute]?? '') . $this->validator['message'];
            //如果定义最大值则去最大值和最小值
            if (isset($this->ruleItem['max'])) {
                $message['max'][$attribute]            = $this->ruleItem['max'];
                $message['min'][$attribute]            = $this->ruleItem['min']?? 0;
                $message['messageMaximum'][$attribute] = ($this->attributeLabels[$attribute]?? '') . sprintf($this->validator['messageMaximum'], $this->ruleItem['max']);
                $message['messageMinimum'][$attribute] = ($this->attributeLabels[$attribute]?? '') . sprintf($this->validator['messageMinimum'], $this->ruleItem['min']);
            }
            //如果只定义一个值则取这个值做最大值和最小值
            if (isset($this->ruleItem[2])) {
                $message['max'][$attribute]            = $this->ruleItem[2];
                $message['min'][$attribute]            = $this->ruleItem[2];
                $message['messageMaximum'][$attribute] = ($this->attributeLabels[$attribute]?? '') . sprintf('长度必须为%d位', $this->ruleItem[2]);
                $message['messageMinimum'][$attribute] = ($this->attributeLabels[$attribute]?? '') . sprintf('长度必须为%d位', $this->ruleItem[2]);
            }
        }
        return $message;
    }
}