<?php
/**
 * Created by PhpStorm.
 * User: nkramer
 * Date: 4/3/2017
 * Time: 4:13 PM
 */

namespace AppBundle\Controller;


class Lookups
{
    public static function classLookup($classId) {
        switch($classId) {
            case 1:
                return 'warrior';
                break;
            case 2:
                return 'paladin';
                break;
            case 3:
                return 'hunter';
                break;
            case 4:
                return 'rogue';
                break;
            case 5:
                return 'priest';
                break;
            case 6:
                return 'death-knight';
                break;
            case 7:
                return 'shaman';
                break;
            case 8:
                return 'mage';
                break;
            case 9:
                return 'warlock';
                break;
            case 10:
                return 'monk';
                break;
            case 11:
                return 'druid';
                break;
            case 12:
                return 'demon-hunter';
                break;
        }
    }

    public static function bossLookup($bossId){
        switch($bossId) {
            case 'Skorpyron':
                return '1849';
                break;
            case 'Chronomatic Anomaly':
                return 1865;
                break;
            case 'Trilliax':
                return 1867;
                break;
            case 'Spellblade Aluriel':
                return 1871;
                break;
            case 'Tichondrius':
                return 1862;
                break;
            case 'Star Augur Etraeus':
                return 1863;
                break;
            case 'Krosus':
                return 1842;
                break;
            case 'High Botanist Tel\'arn':
                return 1886;
                break;
            case 'Grand Magistrix Elisande':
                return 1872;
                break;
            case 'Gul\'dan':
                return 1866;
                break;
        }
    }
}