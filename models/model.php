<?php

abstract class Model implements JsonSerializable {
    public function __construct($attributes = []) {
        foreach ($attributes as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    public function jsonSerialize() {
        $res = [];
        foreach ($this as $key => $value) {
            if ($value instanceof DateTimeInterface) {
                $res[$key] = $value->format("Y-m-d H:i:s.v");
            } else {
                $res[$key] = $value;
            }
        }
        return $res;
    }
}
