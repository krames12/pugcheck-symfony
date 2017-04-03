<?php
/**
 * Created by PhpStorm.
 * User: nkramer
 * Date: 4/3/2017
 * Time: 9:53 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CharacterController extends Controller
{
    /**
     * @Route("/{region}/{serverName}/{characterName}")
     */

    public function characterShow($region, $serverName, $characterName) {
        return $this->render('default/character.html.twig', array(
            'region' => $region,
            'serverName' => $serverName,
            'characterName' => $characterName)
        );
    }

    protected function getCharacterInfo($region, $serverName, $characterName) {

    }

    protected function cleanCharacterName($characterName) {

    }

    protected function parseCharacterInfo($characterInfo) {

    }

    protected function difficultyProgress($difficulty, $bossData) {

    }
}