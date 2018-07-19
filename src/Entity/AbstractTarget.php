<?php

namespace Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;

/**
 * Class AbstractTarget
 *
 * @Entity
 * @InheritanceType("JOINED")
 *
 * @package Fei\Service\Connect\Common\Entity
 */
abstract class AbstractTarget extends AbstractEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @Column(type="boolean")
     *
     * @var bool
     */
    protected $allowProfileAssociation = false;

    /**
     * @OneToMany(targetEntity="Attribution", mappedBy="target", cascade={"all"})
     *
     * @var ArrayCollection|Attribution[];
     */
    protected $attributions;

    /**
     * Get Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param mixed $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get AllowProfileAssociation
     *
     * @return bool
     */
    public function getAllowProfileAssociation()
    {
        return $this->allowProfileAssociation;
    }

    /**
     * Set AllowProfileAssociation
     *
     * @param bool $allowProfileAssociation
     *
     * @return $this
     */
    public function setAllowProfileAssociation($allowProfileAssociation)
    {
        $this->allowProfileAssociation = $allowProfileAssociation;

        return $this;
    }

    /**
     * @return ArrayCollection|Attribution[]
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * @param ArrayCollection|Attribution[] $attributions
     * @return $this
     */
    public function setAttributions($attributions)
    {
        $this->attributions = $attributions;
        return $this;
    }
}
