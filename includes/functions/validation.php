<?php

class validation {
    function __construct ()
    {
        $this->errors = [];
    }

    function fieldname_as_text($fieldname) 
    {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }

    function has_presence($value) 
    {
        return isset($value) && $value !== "";
    }

    function validate_presences($required_fields) 
    {
        foreach($required_fields as $field) 
        {
            $value = trim($_POST[$field]);
            if (!$this->has_presence($value)) 
            {
                $this->errors[$field] = $this->fieldname_as_text($field) . " can't be blank";
            }
        }
    }

    function has_max_length($value, $max) 
    {
        return strlen($value) <= $max;
    }

    function validate_max_lengths($fields_with_max_lengths) 
    {
        foreach($fields_with_max_lengths as $field => $max) 
        {
            $value = trim($_POST[$field]);
            if (!has_max_length($value, $max)) 
            {
                $this->errors[$field] = $this->fieldname_as_text($field) . " is too long";
            }
        }
    }

    function has_inclusion_in($value, $set) 
    {
        return in_array($value, $set);
    }
}