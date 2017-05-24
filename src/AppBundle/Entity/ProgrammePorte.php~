<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgrammePorte
 *
 * @ORM\Table(name="fids_programme_porte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgrammePorteRepository")
 */
class ProgrammePorte
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
     * @ORM\Column(name="idProgramme", type="integer", nullable=true)
     */
    private $idProgramme;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme", inversedBy="programme_portes")
     * @ORM\JoinColumn(name="idProgramme", referencedColumnName="id", nullable=true)
     */
    protected $programme;

    /**
     * @var int
     *
     * @ORM\Column(name="idPorte", type="integer", nullable=true)
     */
    private $idPorte;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Porte", inversedBy="programme_portes")
     * @ORM\JoinColumn(name="idPorte", referencedColumnName="id", nullable=true)
     */
    protected $porte;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="isDeleted", type="boolean", nullable=true)
     */
    private $isDeleted;
    

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
     * Set idProgramme
     *
     * @param integer $idProgramme
     *
     * @return ProgrammePorte
     */
    public function setIdProgramme($idProgramme)
    {
        $this->idProgramme = $idProgramme;

        return $this;
    }

    /**
     * Get idProgramme
     *
     * @return integer
     */
    public function getIdProgramme()
    {
        return $this->idProgramme;
    }

    /**
     * Set idPorte
     *
     * @param integer $idPorte
     *
     * @return ProgrammePorte
     */
    public function setIdPorte($idPorte)
    {
        $this->idPorte = $idPorte;

        return $this;
    }

    /**
     * Get idPorte
     *
     * @return integer
     */
    public function getIdPorte()
    {
        return $this->idPorte;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return ProgrammePorte
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set programme
     *
     * @param \AppBundle\Entity\Programme $programme
     *
     * @return ProgrammePorte
     */
    public function setProgramme(\AppBundle\Entity\Programme $programme = null)
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * Get programme
     *
     * @return \AppBundle\Entity\Programme
     */
    public function getProgramme()
    {
        return $this->programme;
    }

    /**
     * Set porte
     *
     * @param \AppBundle\Entity\Porte $porte
     *
     * @return ProgrammePorte
     */
    public function setPorte(\AppBundle\Entity\Porte $porte = null)
    {
        $this->porte = $porte;

        return $this;
    }

    /**
     * Get porte
     *
     * @return \AppBundle\Entity\Porte
     */
    public function getPorte()
    {
        return $this->porte;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ProgrammePorte
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
}
