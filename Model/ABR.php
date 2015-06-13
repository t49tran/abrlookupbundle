<?php
/**
 * Created by IntelliJ IDEA.
 * User: trant
 * Date: 11/06/2015
 * Time: 11:27 PM
 */

namespace t49tran\AbrLookupBundle\Model;

/**
 * Class ABR
 * @package t49tran\AbrLookupBundle\Model
 * Wrapper class for ABR lookup information from ABR Soap Service
 */
class ABR {

   private $abn_number;
   private $status;
   private $acn_number;
   private $entity_name;
   private $trading_name;
   private $organisation_type;
   private $state;
   private $postcode;

    /**
     * @return mixed
     */
    public function getAbnNumber()
    {
        return $this->abn_number;
    }

    /**
     * @param mixed $abn_number
     */
    public function setAbnNumber($abn_number)
    {
        $this->abn_number = $abn_number;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAcnNumber()
    {
        return $this->acn_number;
    }

    /**
     * @param mixed $acn_number
     */
    public function setAcnNumber($acn_number)
    {
        $this->acn_number = $acn_number;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entity_name;
    }

    /**
     * @param mixed $entity_name
     */
    public function setEntityName($entity_name)
    {
        $this->entity_name = $entity_name;
    }

    /**
     * @return mixed
     */
    public function getTradingName()
    {
        return $this->trading_name;
    }

    /**
     * @param mixed $trading_name
     */
    public function setTradingName($trading_name)
    {
        $this->trading_name = $trading_name;
    }

    /**
     * @return mixed
     */
    public function getOrganisationType()
    {
        return $this->organisation_type;
    }

    /**
     * @param mixed $organisation_type
     */
    public function setOrganisationType($organisation_type)
    {
        $this->organisation_type = $organisation_type;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

}