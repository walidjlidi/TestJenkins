<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, \Serializable {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="est_desactive", type="boolean",nullable=true)
     */
    private $estDesactive;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer" , nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\CyRole")
     */
    private $_roles;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
    function getEstDesactive() {
        return $this->estDesactive;
    }

    function setEstDesactive($estDesactive) {
        $this->estDesactive = $estDesactive;
    }

    
    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function getTel() {
        return $this->tel;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Utilisateur
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Utilisateur
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Utilisateur
     */
    public function setSalt($salt) {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt() {
        return $this->salt;
    }

    public function addRole(\UserBundle\Entity\CyRole $role = null) {
        $this->_roles[] = $role;
        return $this;
    }

    public function removeRole(\UserBundle\Entity\CyRole $role = null) {
        $this->_roles->removeElement($role);
    }

    public function getRoles() {

        return ($this->_roles->toArray());
    }
    
    public function setRoles($roles) {

        $this->_roles = $roles;
    }

    public function eraseCredentials() {
        
    }

    public function serialize() {
        return \serialize(array(
            $this->id,
            $this->nom,
            $this->prenom,
            $this->adresse,
            $this->email,
            $this->tel,
            $this->password,
            $this->username,
            $this->salt
        ));
    }

    public function unserialize($serialized) {
        list(
                $this->id,
                $this->password,
                $this->username,
                $this->salt) = \unserialize($serialized);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Utilisateur
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
}
