<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Vols
 *
 * @ORM\Table(name="fids_vols")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VolsRepository")
 * @UniqueEntity (fields="nom", message="Ce nom existe déjà.")
 */
class Vols
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=255, nullable=true)
     */
    private $depart;
    
    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255, nullable=true)
     */
    private $destination;
    
    /**
    * @ORM\OneToMany(targetEntity="Programme", mappedBy="idVols", orphanRemoval=true , cascade={"all"})
    */
    protected  $programme;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Compagnie", inversedBy="vol", cascade={"persist"})
     * @ORM\JoinColumn(name="id_compagnie", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $idCompagnie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reseau", type="string", length=255, nullable=true)
     */
    private $reseau;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->programme = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Vols
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
     * Set depart
     *
     * @param string $depart
     *
     * @return Vols
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Vols
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Add programme
     *
     * @param \AppBundle\Entity\Programme $programme
     *
     * @return Vols
     */
    public function addProgramme(\AppBundle\Entity\Programme $programme)
    {
        $this->programme[] = $programme;

        return $this;
    }

    /**
     * Remove programme
     *
     * @param \AppBundle\Entity\Programme $programme
     */
    public function removeProgramme(\AppBundle\Entity\Programme $programme)
    {
        $this->programme->removeElement($programme);
    }

    /**
     * Get programme
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgramme()
    {
        return $this->programme;
    }

    /**
     * Set idCompagnie
     *
     * @param \AppBundle\Entity\Compagnie $idCompagnie
     *
     * @return Vols
     */
    public function setIdCompagnie(\AppBundle\Entity\Compagnie $idCompagnie = null)
    {
        $this->idCompagnie = $idCompagnie;

        return $this;
    }

    /**
     * Get idCompagnie
     *
     * @return \AppBundle\Entity\Compagnie
     */
    public function getIdCompagnie()
    {
        return $this->idCompagnie;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Vols
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set reseau
     *
     * @param string $reseau
     *
     * @return Vols
     */
    public function setReseau($reseau)
    {
        $this->reseau = $reseau;

        return $this;
    }

    /**
     * Get reseau
     *
     * @return string
     */
    public function getReseau()
    {
        return $this->reseau;
    }
}
