<?php
namespace App\View\Components;

use Illuminate\View\Component;

class FormGroup extends Component
{
                          // Error Messages
    public $error = null; // IF Need Dispya ERROR WIll Set Message Here

    public $properties = []; // Set All Properties For Input Here
    public $type       = 'text';
    public $name;
    public $value;

    /**
     * Parent Form Group Div Class
     */
    public $formGroupClass = null;

    /**
     * Input Type Allow Accept
     */
    private $allowedType = ['button', 'checkbox', 'color', 'date', 'datetime-local', 'email', 'file', 'hidden', 'image', 'month', 'number', 'password', 'radio', 'range', 'reset', 'search', 'submit', 'tel', 'text', 'time', 'url', 'week'];

    public function setValue($name, $valueProperty)
    {
        $value = old($name);

        if (isset($valueProperty)) {
            if (old($name) == null) {
                $value = $valueProperty;
            }
        }

        return $value;
    }

    /**
     * | $label [ true , false ] default false IF Equal True Display <label></label>
     * | $labelText display text
     * | $labelOptions[] like [ class => 'bg-dark , ....]
     */

    public $label = false; // False = Not Set Label
    public $labelText;
    public $labelOptions = [];

    private function label($properties)
    {
        $this->label = true; // Set Label

        if (isset($properties['text'])) {
            $this->labelText = $properties['text'];
        } else {
            $this->labelText = 'Add Text !';
        }

        if (isset($this->properties['label']['options'])) {
            $this->labelOptions = $this->properties['label']['options'];
        }
    }

    /**
     * |
     * |
     * |
     */
    public $input        = false; // False = Not Set Label
    public $inputOptions = [];
    private function input($properties)
    {
        $this->input = true;
        /**
         * Check If Type Not Exists
         */

        if (isset($properties['type'])) {
            if (! in_array($this->type, $this->allowedType)) {
                echo alert("Input Type ( " . $this->type . " ) Is Incorrect", 'danger');
            } else {
                $this->type = $properties['type'];
            }
        }

        /**
         * Check IF Isset Name
         */
        if (isset($properties['name'])) {
            $this->name = $properties['name'];
        } else {
            echo alert("Input Property ( name ) Does Not Exist", 'danger');
        }

        /**
         * Check IF Have Value Else Set Old()
         */

        if (isset($properties['value'])) {
            $this->value = $this->setValue($this->name, $properties['value']);
        } else {
            $this->value = $this->setValue($this->name, null);
        }

        if (isset($this->properties['input']['options'])) {
            $this->inputOptions = $this->properties['input']['options'];
        }
    }

    /**
     * |
     * |
     * |
     */
    public $textarea        = false; // False = Not Set Label
    public $textareaOptions = [];
    private function textarea($properties)
    {
        $this->textarea = true;

        /**
         * Check IF Isset Name
         */
        if (isset($properties['name'])) {
            $this->name = $properties['name'];
        } else {
            echo alert("Textarea Property ( name ) Does Not Exist", 'danger');
        }

        /**
         * Check IF Have Value Else Set Old()
         */
        if (isset($properties['value'])) {
            $this->value = $this->setValue($this->name, $properties['value']);
        } else {
            $this->value = $this->setValue($this->name, null);
        }

        if (isset($this->properties['textarea']['options'])) {
            $this->textareaOptions = $this->properties['textarea']['options'];
        }
    }

    /**
     * |
     * |
     * |
     */
    public $select        = false; // False = Not Set Label
    public $selectOptions = [];
    public $list          = [];
    public $optionText    = 'name';
    public $optionValue   = 'id';
    public $selected      = null;

    private function select($properties)
    {
        $this->select = true;

        /**
         * Check IF Isset Name
         */
        if (isset($properties['name'])) {
            $this->name = $properties['name'];
        } else {
            echo alert("Select Box Property ( name ) Does Not Exist", 'danger');
        }

        /**
         * Check IF Have Value Else Set Old()
         */

        if (isset($properties['value'])) {
            $this->value = $this->setValue($this->name, $properties['value']);
        }

        /**
         * Check IF Have options
         */

        $this->selectOptions = isset($this->properties['select']['options']) ? $this->properties['select']['options'] : $this->selectOptions;

        /**
         * Check If Have List
         */
        $this->list = isset($this->properties['select']['list']) ? $this->properties['select']['list'] : $this->list;
    }

    public function isSelected($value)
    {
        if (is_array($this->selected)) {
            return in_array($value, $this->selected);
        }

        return $this->selected == $value;
    }

    public function __construct($class = null, $properties = [])
    {
        $this->formGroupClass = $class;
        $this->properties     = $properties;

        if (isset($this->properties['label'])) {
            $this->label($this->properties['label']);
        }

        if (isset($this->properties['input'])) {
            $this->input($this->properties['input']);
        }

        if (isset($this->properties['textarea'])) {
            $this->textarea($this->properties['textarea']);
        }

        if (isset($this->properties['select'])) {
            $this->select($this->properties['select']);
            $this->optionText  = isset($this->properties['select']['text']) ? $this->properties['select']['text'] : $this->optionText;
            $this->optionValue = isset($this->properties['select']['value']) ? $this->properties['select']['value'] : $this->optionValue;
            $this->selected    = isset($this->properties['select']['selected']) ? $this->properties['select']['selected'] : $this->selected;
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-group');
    }
}
