<?php namespace Modules\Setting\Events;

class SettingWasUpdated
{
    /**
     * @var string The setting name
     */
    public $name;
    /**
     * @var string|array
     */
    public $values;
    /**
     * @var string|array Containing the old values
     */
    private $oldValues;
    /**
     * @var bool
     */
    private $isTranslatable;

    public function __construct($name, $isTranslatable, $values, $oldValues = null)
    {
        $this->name = $name;
        $this->isTranslatable = $isTranslatable;
        $this->values = $values;
        $this->oldValues = $oldValues;
    }
}
