<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Vols
 *
 * @ORM\Table(name="fids_programme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgrammeRepository")
 */
class Programme
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
     * @ORM\Column(name="numeroVol", type="string", length=255, nullable=true)
     */
    private $numeroVol;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVols", type="datetime", nullable=true)
     */
    private $dateVols;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureDepart", type="datetime", nullable=true)
     */
    private $heureDepart;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureArrivee", type="datetime", nullable=true)
     */
    private $heureArrivee;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true)
     */
    private $isActive;
    
    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true)
     */
    private $statut;
    
    /**
     * @var string
     *
     * @ORM\Column(name="checkIn", type="string", length=255, nullable=true)
     */
    private $checkIn;
    
    /**
     * @var string
     *
     * @ORM\Column(name="typeAffichage", type="string", length=255, nullable=true)
     */
    private $typeAffichage;
    
    /**
     * @var string
     *
     * @ORM\Column(name="situationBagage", type="string", length=255, nullable=true)
     */
    private $situationBagage;
    
    /** 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vols", inversedBy="programme", cascade={"persist"})
     * @ORM\JoinColumn(name="id_vol", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $idVols;
    
    /** 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Comptoir", inversedBy="programme")
     */
    private $comptoir;
    
    /** 
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Porte", inversedBy="programme")
     */
    private $porte;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgrammeComptoir", mappedBy="programme",cascade={"remove"})
     */
    private $programme_comptoirs;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgrammePorte", mappedBy="programme",cascade={"remove"})
     */
    private $programme_portes;
    

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
     * Set numeroVol
     *
     * @param string $numeroVol
     *
     * @return Programme
     */
    public function setNumeroVol($numeroVol)
    {
        $this->numeroVol = $numeroVol;

        return $this;
    }

    /**
     * Get numeroVol
     *
     * @return string
     */
    public function getNumeroVol()
    {
        return $this->numeroVol;
    }

    /**
     * Set dateVols
     *
     * @param \DateTime $dateVols
     *
     * @return Programme
     */
    public function setDateVols($dateVols)
    {
        $this->dateVols = $dateVols;

        return $this;
    }

    /**
     * Get dateVols
     *
     * @return \DateTime
     */
    public function getDateVols()
    {
        return $this->dateVols;
    }

    /**
     * Set heureDepart
     *
     * @param \DateTime $heureDepart
     *
     * @return Programme
     */
    public function setHeureDepart($heureDepart)
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    /**
     * Get heureDepart
     *
     * @return \DateTime
     */
    public function getHeureDepart()
    {
        return $this->heureDepart;
    }

    /**
     * Set heureArrivee
     *
     * @param \DateTime $heureArrivee
     *
     * @return Programme
     */
    public function setHeureArrivee($heureArrivee)
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * Get heureArrivee
     *
     * @return \DateTime
     */
    public function getHeureArrivee()
    {
        return $this->heureArrivee;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Programme
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Programme
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set typeAffichage
     *
     * @param string $typeAffichage
     *
     * @return Programme
     */
    public function setTypeAffichage($typeAffichage)
    {
        $this->typeAffichage = $typeAffichage;

        return $this;
    }

    /**
     * Get typeAffichage
     *
     * @return string
     */
    public function getTypeAffichage()
    {
        return $this->typeAffichage;
    }

    /**
     * Set situationBagage
     *
     * @param string $situationBagage
     *
     * @return Programme
     */
    public function setSituationBagage($situationBagage)
    {
        $this->situationBagage = $situationBagage;

        return $this;
    }

    /**
     * Get situationBagage
     *
     * @return string
     */
    public function getSituationBagage()
    {
        return $this->situationBagage;
    }

    /**
     * Set idVols
     *
     * @param \AppBundle\Entity\Vols $idVols
     *
     * @return Programme
     */
    public function setIdVols(\AppBundle\Entity\Vols $idVols = null)
    {
        $this->idVols = $idVols;

        return $this;
    }

    /**
     * Get idVols
     *
     * @return \AppBundle\Entity\Vols
     */
    public function getIdVols()
    {
        return $this->idVols;
    }

    /**
     * Set checkIn
     *
     * @param string $checkIn
     *
     * @return Programme
     */
    public function setCheckIn($checkIn)
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    /**
     * Get checkIn
     *
     * @return string
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * Set comptoir
     *
     * @param \AppBundle\Entity\Comptoir $comptoir
     *
     * @return Programme
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
     * Set porte
     *
     * @param \AppBundle\Entity\Porte $porte
     *
     * @return Programme
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
     * Constructor
     */
    public function __construct()
    {
        $this->comptoir = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comptoir
     *
     * @param \AppBundle\Entity\Comptoir $comptoir
     *
     * @return Programme
     */
    public function addComptoir(\AppBundle\Entity\Comptoir $comptoir)
    {
        $this->comptoir[] = $comptoir;

        return $this;
    }

    /**
     * Remove comptoir
     *
     * @param \AppBundle\Entity\Comptoir $comptoir
     */
    public function removeComptoir(\AppBundle\Entity\Comptoir $comptoir)
    {
        $this->comptoir->removeElement($comptoir);
    }

    /**
     * Add porte
     *
     * @param \AppBundle\Entity\Porte $porte
     *
     * @return Programme
     */
    public function addPorte(\AppBundle\Entity\Porte $porte)
    {
        $this->porte[] = $porte;

        return $this;
    }

    /**
     * Remove porte
     *
     * @param \AppBundle\Entity\Porte $porte
     */
    public function removePorte(\AppBundle\Entity\Porte $porte)
    {
        $this->porte->removeElement($porte);
    }

    /**
     * Add programme_comptoirs
     *
     * @param \AppBundle\Entity\ProgrammeComptoir $programme_comptoirs
     *
     * @return Programme
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
     * Add programmePorte
     *
     * @param \AppBundle\Entity\ProgrammePorte $programmePorte
     *
     * @return Programme
     */
    public function addProgrammePorte(\AppBundle\Entity\ProgrammePorte $programmePorte)
    {
        $this->programme_portes[] = $programmePorte;

        return $this;
    }

    /**
     * Remove programmePorte
     *
     * @param \AppBundle\Entity\ProgrammePorte $programmePorte
     */
    public function removeProgrammePorte(\AppBundle\Entity\ProgrammePorte $programmePorte)
    {
        $this->programme_portes->removeElement($programmePorte);
    }

    /**
     * Get programmePortes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgrammePortes()
    {
        return $this->programme_portes;
    }
}
