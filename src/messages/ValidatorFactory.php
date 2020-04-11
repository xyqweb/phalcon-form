<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2019/3/18
 * Time: 16:45
 */

namespace xyqWeb\form\messages;


abstract class ValidatorFactory
{
    /**
     * @var
     */
    protected $ruleItem = [];
    /**
     * @var
     */
    protected $attributeLabels = [];
    /**
     * @var
     */
    protected $validator = [];

    /**
     * ValidatorFactory constructor.
     * @param $ruleItem
     * @param $attributeLabels
     * @param $validator
     */
    public function __construct($ruleItem, $attributeLabels, $validator)
    {
        $this->ruleItem        = $ruleItem;
        $this->attributeLabels = $attributeLabels;
        $this->validator       = $validator;
    }

    /**
     * 获取验证消息及规则
     *
     * @author xyq
     * @return array
     */
    abstract public function getMessage();
}