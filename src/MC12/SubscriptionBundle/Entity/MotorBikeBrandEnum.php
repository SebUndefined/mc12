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
    const ACCOSSATO = "ACCOSSATO";
    const BSA = "BSA";
    const BULTACO = "BULTACO";
    const JOTAGAS = "JOTAGAS";
    const MONTESA = "MONTESA";
    const ROKO = "ROKO";
    const SCORPA = "SCORPA";
    const SWM = "SWM";
    const TM = "TM";
    const VERTIGO = "VERTIGO";
    const ZUNDAPP = "ZUNDAPP";


    protected static $brandName = [
      self::YAMAHA => 'YAMAHA',
        self::HONDA => 'HONDA',
        self::FANTIC => 'FANTIC',
        self::SHERCO => 'SHERCO',
        self::GASGAS => 'GAS-GAS',
        self::BETA => 'BETA',
        self::TRS => 'TRS',
        self::ACCOSSATO => 'ACCOSSATO',
        self::BSA => 'BSA',
        self::BULTACO => 'BULTACO',
        self::JOTAGAS => 'JOTAGAS',
        self::MONTESA => 'MONTESA',
        self::ROKO => 'ROKO',
        self::SCORPA => 'SCORPA',
        self::SWM => 'SWM',
        self::TM => 'TM',
        self::VERTIGO => 'VERTIGO',
        self::ZUNDAPP => 'ZUNDAPP',
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
            self::ACCOSSATO,
            self::BULTACO,
            self::JOTAGAS,
            self::MONTESA,
            self::ROKO,
            self::SCORPA,
            self::SWM,
            self::TM,
            self::VERTIGO,
            self::ZUNDAPP,
        ];
    }
}