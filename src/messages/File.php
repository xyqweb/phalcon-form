<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 20:34
 */

namespace xyqWeb\form\messages;


class File extends ValidatorFactory
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
            $message['message'][$attribute]     = ($this->attributeLabels[$attribute]?? '') . $this->validator['message'];
            $message['maxSize'][$attribute]     = $this->ruleItem['maxSize']?? '20M';
            $message['messageSize'][$attribute] = ($this->attributeLabels[$attribute]?? '') . $this->validator['messageSize'];
            if (isset($this->ruleItem['allowed']) && is_array($this->ruleItem['allowed'])) {
                $message['allowedTypes'][$attribute] = $this->ruleItem['allowed'];
                $message['messageType'][$attribute]  = ($this->attributeLabels[$attribute]?? '') . $this->validator['messageType'];
            }
            if (isset($this->ruleItem['maxResolution'])) {
                $message['maxResolution'][$attribute]        = $this->ruleItem['maxResolution'];
                $message['messageMaxResolution'][$attribute] = ($this->attributeLabels[$attribute]?? '') . $this->validator['messageMaxResolution'];
            }
        }
        return $message;
    }
}