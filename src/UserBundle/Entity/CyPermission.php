<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CyPermission
 *
 * @ORM\Table(name="cy_permission")
 * @ORM\Entity()
 */
class CyPermission
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255, nullable=true)
     */
    private $intitule;

    /**
     * @var int
     *
     * @ORM\Column(name="visible", type="integer", nullable=true)
     */
    private $visible;
    
    /**
     * @var int
     *
     * @ORM\Column(name="groupe", type="integer", nullable=true)
     */
    public $groupe;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return CyPermission
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return CyPermission
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     *
     * @return CyPermission
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return int
     */
    public function getVisible()
    {
        return $this->visible;
    }
    
    function getGroupe() {
        return $this->groupe;
    }

    function setGroupe($groupe) {
        $this->groupe = $groupe;
        return $this;
    }


}

