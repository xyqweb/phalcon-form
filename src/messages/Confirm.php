<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 21:52
 */

namespace xyqWeb\form\messages;


class Confirm extends ValidatorFactory
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
            $withColumns = $this->ruleItem['with'] ?? '';
            $message['with'][$attribute] = $withColumns;
            $message['message'][$attribute] = ($this->attributeLabels[$attribute] ?? '') . sprintf($this->validator['message'], $this->attributeLabels[$withColumns] ?? '');;
        }
        return $message;
    }
}