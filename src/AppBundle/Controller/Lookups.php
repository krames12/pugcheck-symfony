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
            case 1849:
                return 'Skorpyron';
                break;
            case 1865:
                return 'Chronomatic Anomaly';
                break;
            case 1867:
                return 'Trilliax';
                break;
            case 1871:
                return 'Spellblade Aluriel';
                break;
            case 1862:
                return 'Tichondrius';
                break;
            case 1863:
                return 'Star Augur Etraeus';
                break;
            case 1842:
                return 'Krosus';
                break;
            case 1886:
                return 'High Botanist Tel\'arn';
                break;
            case 1872:
                return 'Grand Magistrix Elisande';
                break;
            case 1866:
                return 'Gul\'dan';
                break;
        }
    }
}