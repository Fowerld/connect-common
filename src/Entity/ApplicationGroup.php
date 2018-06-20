<?php

namespace Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;

/**
 * Class ApplicationGroup
 *
 * @Entity
 * @Table(name="application_groups")
 *
 * @package Fei\Service\Connect\Common\Entity
 */
class ApplicationGroup extends AbstractTarget
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string", unique=true)
     *
     * @var string ApplicationGroup name
     */
    protected $name;

    /**
     * Many Groups have Many Applications.
     * @ManyToMany(targetEntity="Application")
     * @JoinTable(name="application_groups_applications",
     *      joinColumns={@JoinColumn(name="application_group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="application_id", referencedColumnName="id")}
     *      )
     */
    protected $applications;

    /**
     * @Column(type="json_array")
     * @var array
     */
    protected $contexts = [];


    /**
     * ApplicationGroup constructor.
     */
    public function __construct()
    {
        $this->applications = new ArrayCollection();

        parent::__construct();
    }


    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @param array $contexts
     * @return ApplicationGroup
     */
    public function setContexts($contexts, $erase = true)
    {
        if (!$erase) {
            $this->contexts = array_merge($this->contexts, $contexts);
        } else {
            $this->contexts = $contexts;
        }
        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addContext($key, $value)
    {
        $this->contexts[$key] = $value;
    }

    /**
     * @param $key
     * @return null
     */
    public function retrieveContext($key)
    {
        return isset($this->contexts[$key]) ? $this->contexts[$key] : null;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param ArrayCollection $applications
     * @return $this
     */
    public function setApplications(ArrayCollection $applications)
    {
        $this->applications = $applications;
        return $this;
    }

    public function addApplication(Application $application)
    {
        $this->applications->add($application);
    }
}