<?php
declare(strict_types=1);

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class RequestService
{

    /**
     * @return mixed
     */
    public static function getField(Request $request, string $fieldname, bool $isRequired = true, bool $isArray = false)
    {
        $requestData = json_decode($request->getContent(), true);

        if ($isArray) {
            $arrayData = self::arrayFlatten($requestData);
            forEach($arrayData as $key => $value) {
                if ($fieldname === $key) {
                    return $value;
                }
            }
            if ($isRequired) {
                throw new BadRequestException(
                    sprintf("Missing field %s required!", $fieldname)
                );
            }

            return null;

        }

        if(array_key_exists($fieldname, $requestData)) {
            return $requestData[$fieldname];
        }

        if ($isRequired) {
            throw new BadRequestException(
                sprintf("Missing field %s required!", $fieldname)
            );
        }

        return null;

    }

    public static function arrayFlatten(array $array): array
    {
        $return = [];

        forEach($array as $key => $value) {
            if (is_array($value)) {
                $return = array_merge($return, self::arrayFlatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }
}