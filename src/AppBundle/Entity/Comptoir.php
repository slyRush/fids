<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Comptoir
 *
 * @ORM\Table(name="fids_comptoir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComptoirRepository")
 */
class Comptoir
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
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isDispo", type="boolean", nullable=true)
     */
    private $isDispo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /** 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Programme", inversedBy="comptoir")
     */
    private $programme;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgrammeComptoir", mappedBy="comptoir")
     */
    private $programme_comptoirs;

    /**
     * @var string
     *
     * @ORM\Column(name="classe", type="string", length=255, nullable=true)
     */
    private $classe;
    
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Comptoir
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set isDispo
     *
     * @param boolean $isDispo
     *
     * @return Comptoir
     */
    public function setIsDispo($isDispo)
    {
        $this->isDispo = $isDispo;

        return $this;
    }

    /**
     * Get isDispo
     *
     * @return boolean
     */
    public function getIsDispo()
    {
        return $this->isDispo;
    }

    /**
     * Add programme
     *
     * @param \AppBundle\Entity\Programme $programme
     *
     * @return Comptoir
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
     * Add programme_comptoirs
     *
     * @param \AppBundle\Entity\ProgrammeComptoir $programme_comptoirs
     *
     * @return Comptoir
     */
    public function addProgrammeComptoir(\AppBundle\Entity\ProgrammeComptoir $programme_comptoirs)
    {
        $this->programme_comptoirs[] = $programme_comptoirs;

        return $this;
    }

    /**
     * Remove programme_comptoirs
     *
     * @param \AppBundle\Entity\ProgrammeComptoir $programme_comptoirs
     */
    public function removeProgrammeComptoir(\AppBundle\Entity\ProgrammeComptoir $programme_comptoirs)
    {
        $this->programme_comptoirs->removeElement($programme_comptoirs);
    }

    /**
     * Get programme_comptoirs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgrammeComptoir()
    {
        return $this->programme_comptoirs;
    }

    /**
     * Get programmeComptoirs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgrammeComptoirs()
    {
        return $this->programme_comptoirs;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Comptoir
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
     * Set classe
     *
     * @param string $classe
     *
     * @return Comptoir
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return string
     */
    public function getClasse()
    {
        return $this->classe;
    }
}
