<?php
/**
 * Created by PhpStorm.
 * User: nkramer
 * Date: 4/5/2017
 * Time: 11:21 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="servers")
 */
class Servers
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $serverName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $serverSlug;


    /**
     * @ORM\Column(type="string", length=10)
     */
    private $region;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set serverName
     *
     * @param string $serverName
     *
     * @return Servers
     */
    public function setServerName($serverName)
    {
        $this->serverName = $serverName;

        return $this;
    }

    /**
     * Get serverName
     *
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * Set serverSlug
     *
     * @param string $serverSlug
     *
     * @return Servers
     */
    public function setServerSlug($serverSlug)
    {
        $this->serverSlug = $serverSlug;

        return $this;
    }

    /**
     * Get serverSlug
     *
     * @return string
     */
    public function getServerSlug()
    {
        return $this->serverSlug;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return Servers
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }
}
