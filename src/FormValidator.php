<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: XYQ
 * Date: 2020-04-11
 * Time: 20:03
 */

namespace xyqWeb\form;


use Phalcon\Validation;

class FormValidator extends Validation
{
    /**
     * @var null|array 错误消息集合
     */
    private $errorMsg = null;
    /**
     * @var FormFactory
     */
    private $form;

    /**
     * FormValidator constructor.
     * @param FormFactory $form
     * @param array|null $validators
     */
    public function __construct(FormFactory $form, array $validators = null)
    {
        parent::__construct($validators);
        $this->form = $form;
    }

    /**
     * 获取验证规则类
     *
     * @author xyq
     * @param null|string $type
     * @return array
     * @throws \Exception
     */
    private function getValidator(string $type = null) : array
    {
        $validators = [
            //验证字段值只能是字母和数字字符
            'alnum'        => [
                'Phalcon\Validation\Validator\Alnum',
                [
                    'message' => '只能是字母和数字字符'
                ]
            ],
            //验证字段值只能是字母字符
            'alpha'        => [
                'Phalcon\Validation\Validator\Alpha',
                [
                    'message' => '只能是字母字符'
                ]
            ],
            //验证字段值是一个有效的日期。
            'date'         => [
                'Phalcon\Validation\Validator\Date',
                [
                    'message' => '必须是一个有效的日期。'
                ]
            ],
            //验证字段值只能是数字字符。
            'integer'      => [
                'Phalcon\Validation\Validator\Digit',
                [
                    'message' => '只能是数字字符。'
                ]
            ],
            //验证字段的值是正确的文件。
            'file'         => [
                'Phalcon\Validation\Validator\File',
                [
//                    "maxSize" => "20M",
                    "messageSize"          => "不能大于(:max)",
                    'message'              => '是正确的文件。',
                    "messageMaxResolution" => "最大分辨率不能超过 :max",
                ]
            ],
            //验证字段值是一个有效的数值
            'number'       => [
                'Phalcon\Validation\Validator\Numericality',
                [
                    'message' => '必须是一个有效的数值'
                ]
            ],
            //验证字段的值不是 null 或空字符串
            'required'     => [
                'Phalcon\Validation\Validator\PresenceOf',
                [
                    'message' => '必须不是 null 或空字符串'
                ]
            ],
            //验证字段值是否于指定的值相同
            'identical'    => [
                'Phalcon\Validation\Validator\Identical',
                [
                    'message' => '是否于指定的值相同'
                ]
            ],
            //验证字段包含一个有效的电子邮件格式
            'email'        => [
                'Phalcon\Validation\Validator\Email',
                [
                    'message' => '必须是一个有效的电子邮件格'
                ]
            ],
            //验证的值不在列表中
            'notIn'        => [
                'Phalcon\Validation\Validator\ExclusionIn',
                [
                    'message' => '必须不在列表%s中',
                ]
            ],
            //验证值存在列表中
            'in'           => [
                'Phalcon\Validation\Validator\InclusionIn',
                [
                    'message' => '只能在%s列表中',
                ]
            ],
            //验证字段的值匹配的正则表达式
            'regex'        => [
                'Phalcon\Validation\Validator\Regex',
                [
                    'message' => '必须是匹配的正则表达式'
                ]
            ],
            //验证一个字符串的长度
            'length'       => [
                'Phalcon\Validation\Validator\StringLength',
                [
                    "messageMaximum" => "最大长度不能超过%d位",
                    "messageMinimum" => "最小长度不能低于%d位",
                ]
            ],
            //验证值是两个值之间
            'between'      => [
                'Phalcon\Validation\Validator\Between',
                [
                    'message' => '两个%d和%d值之间'
                ]
            ],
            //验证值是相同的数据中的字段
            'confirm'      => [
                'Phalcon\Validation\Validator\Confirmation',
                [
                    'message' => '必须和%s相同',
                ]
            ],
            //验证字段包含一个有效的 URL
            'url'          => [
                'Phalcon\Validation\Validator\Url',
                [
                    'message' => '必须是一个有效的 URL'
                ]
            ],
            //验证的信用卡卡号
            'creditCard'   => [
                'Phalcon\Validation\Validator\CreditCard',
                [
                    'message' => '必须是信用卡卡号'
                ]
            ],
            //验证时使用回调函数
            'callback'     => [
                'Phalcon\Validation\Validator\Callback',
                [
                    'message' => '必须是回调函数',
                ]
            ],
            //验证是手机号码
            'mobile'       => [
                'xyqWeb\form\validators\MobileValidator',
                [
                    'message' => '必须是有效的手机号码',
                ]
            ],
            //验证是手机号码前缀
            'mobilePrefix' => [
                'xyqWeb\form\validators\MobilePrefixValidator',
                [
                    'message' => '必须是有效的手机号前缀',
                ]
            ],
        ];
        if (is_string($type) && !array_key_exists($type, $validators)) {
            throw new \Exception('验证规则不存在');
        }
        return is_null($type) ? $validators : $validators[$type];
    }

    /**
     * 重写底层验证
     *
     * @author xyq
     * @param null $data
     * @param null $entity
     * @return bool
     * @throws \Exception
     */
    public function validate($data = null, $entity = null) : bool
    {
        $this->setRules($data);
        $validateResult = parent::validate($data, $entity);
        $errorMsg = [];
        if (count($validateResult)) {
            foreach ($validateResult as $message) {
                $errorMsg[] = (string)$message;
            }
        }
        $this->errorMsg = $errorMsg;
        return empty($errorMsg) ? true : false;
    }

    /**
     * 设置验证规则
     *
     * @author xyq
     * @param $data
     * @throws \Exception
     */
    private function setRules($data)
    {
        $dataKeyArray = array_keys($data);
        $validatorArray = $this->getValidator();
        $attributeLabels = $this->form->attributeLabels();
        foreach ($this->form->rules() as $rule) {
            //不是必须验证的则看传入的数据是否已传，传即验证不传废掉该规则
            if ('required' != $rule[1]) {
                $temp = [];
                foreach ($rule[0] as $item) {
                    if (in_array($item, $dataKeyArray)) {
                        $temp[] = $item;
                    }
                }
                if (empty($temp)) {
                    continue;
                }
                $rule[0] = $temp;
            }
            //获取每个验证规则对应phalcon对应的类及报错信息
            $validatorItem = $validatorArray[$rule[1]];
            //phalcon对应每个规则的验证类
            $validatorClassName = $validatorItem[0] ?? '';
            $validatorMessageName = '\xyqWeb\form\messages\\' . ucfirst($rule[1]);
            /** @var  $validatorMessageObject \xyqWeb\form\messages\ValidatorFactory */
            $validatorMessageObject = new $validatorMessageName($rule, $attributeLabels, $validatorItem[1]);
            //注入验证规则到phalcon中
            $this->add($rule[0], new $validatorClassName($validatorMessageObject->getMessage()));
        }
    }

    /**
     * 验证完成后处理数据
     *
     * @author xyq
     * @param array $data
     */
    public function afterValidation(array $data)
    {
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $this->filterArray($item);
            } else {
                $item = is_numeric($item) ? $item : $this->filterValue($item);
            }
            $this->_data[$key] = $item;
        }
    }

    /**
     * 过滤字符串内不合法数据
     *
     * @author xyq
     * @param string|null $item
     * @return string
     */
    private function filterValue(string $item = null) : string
    {
        if (is_null($item)) {
            return '';
        }
        $item = preg_replace('/[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]/', '', $item); //去掉控制字符
        $item = str_replace(array("\0", "%00", "\r"), '', $item); //\0表示ASCII 0x00的字符，通常作为字符串结束标志；这三个都是可能有害字符
        $item = str_replace(array("%3C", '<'), '<', $item); //ascii的'<'转成'<';
        $item = str_replace(array("%3E", '>'), '>', $item);
        $item = str_replace(array("'", "\t", ' '), array('‘', ' ', ' '), $item);
        $item = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i", "&111n\\2", $item);
        $item = preg_replace("/(.*?)<\/script>/si", "", $item);
        $item = preg_replace("/(.*?)<\/iframe>/si", "", $item);
        $sql = array("select", 'insert', "update", "delete", "\'", "\/\*", "\.\.\/", "\.\/", "union", "into", "load_file", "outfile");
        $item = str_replace($sql, '', $item);
        $item = str_replace(array('<?', '?>'), '', $item);
        $item = $this->filterStr($item);
        return trim($item);
    }

    /**
     * 过滤数组类的参数
     *
     * @author xyq
     * @param $item
     */
    private function filterArray(&$item)
    {
        foreach ($item as $k => &$v) {
            if (is_array($v)) {
                $this->filterArray($v);
            } else {
                $v = is_numeric($v) ? $v : $this->filterValue($v);
            }
        }
    }

    /**
     * 字符串过滤 过滤特殊有危害字符
     *
     * @author xyq
     * @param string $value
     * @return mixed|string
     */
    protected function filterStr(string $value)
    {
        $badStr = array("\0", "%00", "\r", '&', ' ', '"', "'", "<", ">", "   ", "%3C", "%3E");
        $newStr = array('', '', '', '&', ' ', '"', "''", "<", ">", "   ", "<", ">");
        $value = str_replace($badStr, $newStr, $value);
        $value = preg_replace('/&((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $value);
        return $value;
    }

    /**
     * 获取第一个错误信息
     *
     * @author xyq
     * @return string
     */
    public function getFirstError() : string
    {
        return current($this->errorMsg);
    }

    /**
     * 获取全部错误消息
     *
     * @author xyq
     * @return null|array
     */
    public function getErrors() : array
    {
        return $this->errorMsg;
    }

    /**
     * 获取处理完成的数据
     *
     * @author xyq
     * @return array
     */
    public function getData() : array
    {
        return $this->_data;
    }
}