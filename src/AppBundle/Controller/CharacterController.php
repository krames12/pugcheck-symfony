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
        $progressionData = $this->parseProgressionData($characterData->progression->raids);

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

    protected function parseProgressionData($characterData) {
        $currentRaidData = array_filter($characterData, function($raid) {
            if($raid->name == 'The Nighthold') {
                $formattedRaid = $raid;
                $formattedRaid->difficulty = 2;
                $formattedRaid->highestDifficulty = 'Looking For Raid';
                foreach($raid->bosses as $boss) {
                    if($boss->mythicKills > 0) {
                        $formattedRaid->difficulty = 5;
                        $formattedRaid->highestDifficulty = 'Mythic';
                    } else if($boss->heroicKills > 0) {
                        $formattedRaid->difficulty = 4;
                        $formattedRaid->highestDifficulty = 'Heroic';
                    } else if($boss->normalKills > 0) {
                        $formattedRaid->difficulty = 3;
                        $formattedRaid->highestDifficulty = 'Normal';
                    }
                }

                return $formattedRaid;
            }
        });

        return $currentRaidData; //current last array spot. put a better fix in there.
    }

    protected function difficultyProgress($difficulty, $bossData) {

    }
}