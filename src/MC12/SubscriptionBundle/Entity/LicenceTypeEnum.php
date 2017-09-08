<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 08/09/17
 * Time: 12:53
 */

namespace MC12\SubscriptionBundle\Entity;


abstract class LicenceTypeEnum
{

    const FFM = "FFM";
    const FIM = "FIM";
    const ONE_DAY_LICENCE = "OneDay";

    protected static $typeName = [
      self::FFM => 'Licence FFM',
        self::FIM => 'Licence FIM',
        self::ONE_DAY_LICENCE => 'Race Licence'
    ];

    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::FFM,
            self::FIM,
            self::ONE_DAY_LICENCE
        ];
    }
}