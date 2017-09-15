<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 08/09/17
 * Time: 12:53
 */

namespace MC12\SubscriptionBundle\Entity;


abstract class MotorBikeBrandEnum
{

    const YAMAHA = "Yamaha";
    const HONDA = "Honda";
    const FANTIC = "Fantic";
    const SHERCO = "Sherco";
    const GASGAS = "Gas-Gas";
    const BETA = "Beta";
    const TRS = "TRS";


    protected static $brandName = [
      self::YAMAHA => 'Yamaha',
        self::HONDA => 'Honda',
        self::FANTIC => 'Fantic',
        self::SHERCO => 'Sherco',
        self::GASGAS => 'Gas-Gas',
        self::BETA => 'Beta',
        self::TRS => 'TRS',
    ];

    public static function getTypeName($brandShortName)
    {
        if (!isset(static::$brandName[$brandShortName])) {
            return "Unknown type ($brandShortName)";
        }

        return static::$brandName[$brandShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::YAMAHA,
            self::HONDA,
            self::FANTIC,
            self::SHERCO,
            self::GASGAS,
            self::BETA,
            self::TRS,
        ];
    }
}