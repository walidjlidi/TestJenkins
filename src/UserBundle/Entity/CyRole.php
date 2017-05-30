<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CyRole
 *
 * @ORM\Table(name="cy_role")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CyRoleRepository")
 * @UniqueEntity(fields="nom", message="Un rôle existe déjà avec ce nom.")
 */
class CyRole implements RoleInterface
{



/**
    * @ORM\ManyToMany(targetEntity="UserBundle\Entity\CyPermission", cascade={"persist"})
    */
   private $permissions;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    public function addPermission(CyPermission $permission)
    {
        $this->permissions[] = $permission;
        return $this;
    }

    public function removePermission(CyPermission $permission)
    {
        $this->permissions->removeElement($permission);
    }

    public function getPermissions()
    {
        return $this->permissions->toArray();
    }
    
    public function setPermissions($permissions)
    {
        return $this->permissions = $permissions;
    }




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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="role_provisoire", type="integer",nullable=true)
     */
    private $roleProvisoire ;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return CyRole
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CyRole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getRole()
    {
        return $this->nom;
    }
    
    function getRoleProvisoire() {
        return $this->roleProvisoire;
    }

    function setRoleProvisoire($roleProvisoire) {
        $this->roleProvisoire = $roleProvisoire;
    }







}

