<?php

namespace App\Component\Debug;

use ReflectionClass;

class ArrayHelper
{
    public static function makeObjectFromArray(string $class, array $array): object
    {
        $object = new $class();
        return self::fillObjectFromArray($object, $array);
    }

    public static function fillObjectFromArray($object, array $array)
    {
        $reflectionClass = new ReflectionClass($object);
        foreach ($reflectionClass->getProperties() as $property) {
            $propName = $property->getName();
            if (isset($array[$propName])) {
                $property->setAccessible(true);
                $property->setValue($object, $array[$propName]);
                $property->setAccessible(false);
            }
        }
        return $object;
    }

    public static function camelize(array $data): array
    {
        $arr = [];
        foreach ($data as $key => $value) {
            $key = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));

            if (is_array($value)) {
                $value = self::camelize($value);
            }

            $arr[$key] = $value;
        }
        return $arr;
    }

    public static function objectToArray(object $object): array
    {
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }
        return $array;
    }
}
