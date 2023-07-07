<?php

class RequestValidator
{
    public function __construct(private array $rules = [])
    {
    }

    public function validate($data)
    {
        $vData = [];
        foreach ($this->rules as $key => $rule) {
            $parts = explode("|", $rule);
            if (!in_array("required", $parts) && !array_key_exists($key, $data)) {
                continue;
            }
            foreach ($parts as $part) {
                $ruleName = $rule = null;
                if (str_contains($part, "=")) {
                    [$ruleName, $rule] = explode("=", $part);
                } else {
                    $ruleName = $part;
                }
                switch ($ruleName) {
                    case "required": {
                        if (!$this->validateRequirement($data, $key)) {
                            throw new UnprocessedEntity("{$key} cannot be empty.");
                        }
                        break;
                    }
                    case "int_str": {
                        if (!$this->validateIntStr($data[$key])) {
                            throw new UnprocessedEntity("{$key} must be int string.");
                        }
                        break;
                    }
                    case "type": {
                        if (!$this->validateType($rule, $data[$key])) {
                            throw new UnprocessedEntity("{$key} must be {$rule}.");
                        }
                        break;
                    }
                    case "min": {
                        if (!$this->validateMin(floatval($rule), $data[$key])) {
                            throw new UnprocessedEntity("{$key} must greater or equal than {$rule}.");
                        }
                    }
                }
            }
            if (array_key_exists($key, $data)) {
                $vData[$key] = $data[$key];
            }
        }
        return $vData;
    }

    private function validateType(string $type, $value) {
        $valueType = gettype($value);
        if ($type === "double") {
            return $valueType === "double" || $valueType === "integer";
        }
        return $valueType === $type;
    }

    private function validateRequirement($data, string $key) {
        if (!array_key_exists($key, $data)) {
            return false;
        }
        if (gettype($data[$key]) === "boolean") {
            return true;
        }
        return !empty($data[$key]);
    }

    private function validateIntStr($value) {
        return gettype($value) === "string" && preg_match("/^[0-9]+$/", $value);        
    }

    private function validateMin($min, $value) {
        return $value >= $min;
    }
}
