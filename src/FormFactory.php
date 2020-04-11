<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2020-04-11
 * Time: 20:01
 */

namespace xyqWeb\form;


abstract class FormFactory
{
    /**
     * @var array|null 自定义配置信息
     */
    protected $config;

    /**
     * FormFactory constructor.
     * @param array|null $config
     */
    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

    /**
     * 设置验证规则
     *
     * @author xyq
     * @return array
     */
    abstract public function rules();

    /**
     * 设置字段对应解释
     *
     * @author xyq
     * @return array
     */
    abstract public function attributeLabels();
}