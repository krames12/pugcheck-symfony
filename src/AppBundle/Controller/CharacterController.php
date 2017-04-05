<?php
/**
 * Created by PhpStorm.
 * User: nkramer
 * Date: 4/3/2017
 * Time: 9:53 AM
 */

namespace AppBundle\Controller;

use AppBundle\Controller\Lookups;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Controller\Lookups;

class CharacterController extends Controller
{
    /**
     * @Route("/{region}/{serverName}/{characterName}")
     */

    public function characterShow($region, $serverName, $characterName) {
        $wclKey = getEnv('WCL_KEY');
        $blizzKey = getEnv('BLIZZ_KEY');
        $cleanName = $characterName; //use $this->cleanName in the future once you actually write it
        $blizzUrl = 'https://'.$region.'.api.battle.net/wow/character/'.$serverName.'/'.$cleanName.'?fields=progression,items&locale=en_US&apikey='.$blizzKey;
        $wclUrl = 'https://www.warcraftlogs.com:443/v1/rankings/character/'.$cleanName.'/'.$serverName.'/'.$region.'?api_key='.$wclKey;

        $characterData = json_decode($this->getCharacterInfo($blizzUrl));
        $warcraftLogsData = json_decode($this->getCharacterInfo($wclUrl));
        $progressionData = $this->parseProgressionData($characterData->progression->raids, $warcraftLogsData);

        return $this->render('default/character.html.twig', array(
            'region' => $region,
            'serverName' => $characterData->realm,
            'characterName' => $characterData->name,
            'characterClass' => Lookups::classLookup($characterData->class),
            'classImage' => Lookups::classLookup($characterData->class).'.png',
            'itemLevel' => $characterData->items->averageItemLevel,
            'progressionData' => $progressionData,
            'logData' => $warcraftLogsData,
            'data' => $characterData
        ));
    }

    protected function getCharacterInfo($requestUrl) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $requestUrl
        ));

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    protected function cleanCharacterName($characterName) {

    }

    protected function parseProgressionData($characterData, $logData) {
        $this->logs = $logData;
        $currentRaidData = array_filter($characterData, function($raid) {
            if($raid->name == 'The Nighthold') {
                $formattedRaid = $raid;
                $formattedRaid->totalBosses = count($raid->bosses);
                $formattedRaid->difficulty = 2;
                $formattedRaid->highestDifficulty = 'Looking For Raid';

                $formattedRaid->lfrProgress = $this->difficultyProgress('lfr', $raid->bosses);
                $formattedRaid->normalProgress = $this->difficultyProgress('normal', $raid->bosses);
                $formattedRaid->heroicProgress = $this->difficultyProgress('heroic', $raid->bosses);
                $formattedRaid->mythicProgress = $this->difficultyProgress('mythic', $raid->bosses);

                foreach($raid->bosses as $boss) {
                    if($boss->mythicKills > 0) {
                        $formattedRaid->difficulty = 5;
                        $formattedRaid->highestDifficulty = 'Mythic';
                    } else if($boss->heroicKills > 0 && $formattedRaid->difficulty < 4) {
                        $formattedRaid->difficulty = 4;
                        $formattedRaid->highestDifficulty = 'Heroic';
                    } else if($boss->normalKills > 0 && $formattedRaid->difficulty < 3) {
                        $formattedRaid->difficulty = 3;
                        $formattedRaid->highestDifficulty = 'Normal';
                    }

                    foreach($this->logs as $log) {
                        if(Lookups::bossLookup($boss->name) == $log->encounter) {
                            if($log->difficulty == 5) {
                                $boss->mythicReportUrl = 'https://www.warcraftlogs.com/reports/'.$log->reportID.'#fight='.$log->fightID;
                            } else if($log->difficulty == 4) {
                                $boss->heroicReportUrl = 'https://www.warcraftlogs.com/reports/'.$log->reportID.'#fight='.$log->fightID;
                            } else if($log->difficulty == 3) {
                                $boss->normalReportUrl = 'https://www.warcraftlogs.com/reports/'.$log->reportID.'#fight='.$log->fightID;
                            } else if($log->difficulty == 2) {
                                $boss->lfrReportUrl = 'https://www.warcraftlogs.com/reports/'.$log->reportID.'#fight='.$log->fightID;
                            }

                        }
                    }
                }
                return $formattedRaid;
            }
        });
        return $currentRaidData; //current last array spot. put a better fix in there.
    }

    protected function difficultyProgress($difficulty, $bossData) {
        $killSearch = $difficulty.'Kills';
        $progress = 0;

        foreach($bossData as $boss) {
            if($boss->$killSearch > 0) {
                $progress+= 1;
            }
        }
        return $progress;
    }
}