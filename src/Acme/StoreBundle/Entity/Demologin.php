<?php

namespace Acme\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demologin
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Demologin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="accesskey", type="text")
     */
    private $accesskey;

    /**
     * @var string
     *
     * @ORM\Column(name="uname", type="string", length=100)
     */
    private $uname;

    /**
     * @var string
     *
     * @ORM\Column(name="client_ip", type="string", length=20)
     */
    private $client_ip;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="expireat", type="integer")
     */
    private $expireat;

    /**
     * Set id
     *
     * @param integer $id
     * @return Demologin
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

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
     * Set accesskey
     *
     * @param string $accesskey
     * @return Demologin
     */
    public function setAccesskey($accesskey)
    {
        $this->accesskey = $accesskey;
    
        return $this;
    }

    /**
     * Get accesskey
     *
     * @return string 
     */
    public function getAccesskey()
    {
        return $this->accesskey;
    }

    /**
     * Set uname
     *
     * @param string $uname
     * @return Demologin
     */
    public function setUname($uname)
    {
        $this->uname = $uname;
    
        return $this;
    }

    /**
     * Get uname
     *
     * @return string 
     */
    public function getUname()
    {
        return $this->uname;
    }
    /**
     * Set expireat
     *
     * @param integer $expireat
     * @return Demologin
     */
    public function setExpireat($expireat)
    {
    	$this->expireat = $expireat;
    
    	return $this;
    }
    
    /**
     * Get expireat
     *
     * @return integer
     */
    public function getExpireat()
    {
    	return $this->expireat;
    }
    /**
     * Set client_ip
     *
     * @param string $client_ip
     * @return Demologin
     */
    public function setClient_ip($client_ip)
    {
    	$this->client_ip = $client_ip;
    
    	return $this;
    }
    
    /**
     * Get client_ip
     *
     * @return string
     */
    public function getClient_ip()
    {
    	return $this->client_ip;
    }
}
