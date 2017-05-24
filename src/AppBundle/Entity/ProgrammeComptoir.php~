<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgrammeComptoir
 *
 * @ORM\Table(name="fids_programme_comptoir")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgrammeComptoirRepository")
 */
class ProgrammeComptoir
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programme", inversedBy="programme_comptoirs")
     * @ORM\JoinColumn(name="idProgramme", referencedColumnName="id", nullable=true)
     */
    protected $programme;

    /**
     * @var int
     *
     * @ORM\Column(name="idComptoir", type="integer", nullable=true)
     */
    private $idComptoir;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comptoir", inversedBy="programme_comptoirs")
     * @ORM\JoinColumn(name="idComptoir", referencedColumnName="id", nullable=true)
     */
    protected $comptoir;
    
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
     * @return ProgrammeComptoir
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
     * Set idComptoir
     *
     * @param integer $idComptoir
     *
     * @return ProgrammeComptoir
     */
    public function setIdComptoir($idComptoir)
    {
        $this->idComptoir = $idComptoir;

        return $this;
    }

    /**
     * Get idComptoir
     *
     * @return integer
     */
    public function getIdComptoir()
    {
        return $this->idComptoir;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return ProgrammeComptoir
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
     * @return ProgrammeComptoir
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
     * Set comptoir
     *
     * @param \AppBundle\Entity\Comptoir $comptoir
     *
     * @return ProgrammeComptoir
     */
    public function setComptoir(\AppBundle\Entity\Comptoir $comptoir = null)
    {
        $this->comptoir = $comptoir;

        return $this;
    }

    /**
     * Get comptoir
     *
     * @return \AppBundle\Entity\Comptoir
     */
    public function getComptoir()
    {
        return $this->comptoir;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ProgrammeComptoir
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
