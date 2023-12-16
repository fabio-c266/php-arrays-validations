<?php

namespace src\core;

use Exception;

class Schema
{
    protected static array $errors = [];
    private static array $dataValidated = [];
    public const AVALIABLE_TYPES = [
        "string"
    ];

    public static function validate(array $schema, array $data)
    {
        foreach ($schema as $schemaKey => $schemaValidationsMethods) {
            if (gettype($schemaValidationsMethods) !== 'array') {
                throw new Exception("The schema value must be a array with the validation methods.");
            }

            $class = 'src\\core\\Validations';
            $classInstance = new $class();

            $validationType = $schemaValidationsMethods[0] ?? null;
            $valueOptinalOrRequired = $schemaValidationsMethods[1] ?? null;

            if (!in_array($validationType, self::AVALIABLE_TYPES)) {
                throw new Exception("Is need use first the data type in {$schemaKey}.");
            }

            if (!in_array($valueOptinalOrRequired, ["required", "optional"])) {
                throw new Exception("Is need set if is required or optinal in {$schemaKey}.");
            }

            $index = 0;
            foreach ($schemaValidationsMethods as $validationMethod) {
                [$method, $param] = str_contains($validationMethod, ':') ? explode(':', $validationMethod) : [$validationMethod, null];

                if (!method_exists($classInstance, $method)) {
                    throw new Exception("Invalid validate method in {$schemaKey} => ['{$method}'].");
                }

                $classInstance->setData($data[$schemaKey] ?? null);
                $classInstance->setParam($param);

                try {
                    if ($valueOptinalOrRequired === 'optional' && $classInstance->getData() === null) {
                        break;
                    }

                    if ($index === 0) {
                        call_user_func_array([$classInstance, $valueOptinalOrRequired], []);
                    } else {
                        if ($index === 1) {
                            $method = $validationType;
                        }

                        call_user_func_array([$classInstance, $method], []);
                    }

                    if (!array_key_exists($schemaKey, self::$dataValidated)) {
                        self::$dataValidated[$schemaKey] = $classInstance->getData();
                    }
                } catch (Exception $except) {
                    self::$errors[] = "{$schemaKey}: {$except->getMessage()}";
                    break;
                } finally {
                    $index++;
                }
            }
        }

        if (count(self::$errors) > 0) {
            throw new Exception(self::$errors[0]);
        }

        return self::$dataValidated;
    }
}
