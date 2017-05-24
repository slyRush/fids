<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
//use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Vols
 *
 * @ORM\Table(name="fids_compagnie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompagnieRepository")
 * @UniqueEntity (fields="nom", message="Cette compagnie existe déjà.")
 */
class Compagnie
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
     * @ORM\Column(name="id_compagnie", type="string", length=255, nullable=true)
     */
    private $idCompagnie;
    
    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;
    
    /**
    * @ORM\OneToMany(targetEntity="Vols", mappedBy="idCompagnie", orphanRemoval=true , cascade={"all"})
    */
    protected  $vol;

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
     * @return Compagnie
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Compagnie
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Add programme
     *
     * @param \AppBundle\Entity\Programme $programme
     *
     * @return Compagnie
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
     * @param string $idCompagnie
     *
     * @return Compagnie
     */
    public function setIdCompagnie($idCompagnie)
    {
        $this->idCompagnie = $idCompagnie;

        return $this;
    }

    /**
     * Get idCompagnie
     *
     * @return string
     */
    public function getIdCompagnie()
    {
        return $this->idCompagnie;
    }

    /**
     * Add vol
     *
     * @param \AppBundle\Entity\Vols $vol
     *
     * @return Compagnie
     */
    public function addVol(\AppBundle\Entity\Vols $vol)
    {
        $this->vol[] = $vol;

        return $this;
    }

    /**
     * Remove vol
     *
     * @param \AppBundle\Entity\Vols $vol
     */
    public function removeVol(\AppBundle\Entity\Vols $vol)
    {
        $this->vol->removeElement($vol);
    }

    /**
     * Get vol
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVol()
    {
        return $this->vol;
    }
}
