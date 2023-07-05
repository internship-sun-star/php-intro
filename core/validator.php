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
                    case "type": {
                        if (!$this->validateType($rule, $data[$key])) {
                            throw new UnprocessedEntity("{$key} must be {$rule}.");
                        }
                        break;
                    }
                }
                $vData[$key] = $data[$key];
            }
        }
        return $vData;
    }

    private function validateType(string $type, $value) {
        return gettype($value) === $type;
    }

    private function validateRequirement($data, string $key) {
        return array_key_exists($key, $data) && !empty($data[$key]);
    }
}
