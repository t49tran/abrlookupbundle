<?php
/**
 * Created by IntelliJ IDEA.
 * User: trant
 * Date: 11/06/2015
 * Time: 11:27 PM
 */

namespace t49tran\AbrLookupBundle\LookupService;

use t49tran\AbrLookupBundle\Model\ABR;

class LookupService {

    protected $soap_client;

    protected $soap_end_point;

    protected $abr_api_key;
    /**
     * @var ABR
     */
    protected $abr;

    public function __construct($abr_api_key,$soap_end_point){
        $this->soap_end_point = $soap_end_point;
        $this->abr_api_key = $abr_api_key;
        $this->soap_client = new  \nusoap_client($this->soap_end_point, true);;
    }

    /**
     * @param $abn
     * @param bool $historical_details
     * @return $this|null
     *
     * TODO: merge this function with acnLookUp function to remove duplicated lines
     */
    public function abnLookUp($abn,$historical_details = false){

        $abn = preg_replace("/\s/", "", $abn);

        $historical_details = ($historical_details) ? "Y" : "N";

        $param = array('searchString' => $abn,
                       'includeHistoricalDetails' => $historical_details,
                       'authenticationGuid' => $this->abr_api_key
        );

        $result = $this->soap_client->call("ABRSearchByABN",array('parameters' => $param), '', '', false, true);

        if($this->soap_client->fault)
            return null;

        if(!empty($result["ABRPayloadSearchResults"]["response"]["exception"]))
            return null;

        $abr = $this->initializeAbr($result);

        $this->abr = $abr;

        return $this;
    }

    public function acnLookup($acn,$historical_details = false){
        $acn = preg_replace("/\s/", "", $acn);

        $historical_details = ($historical_details) ? "Y" : "N";

        $param = array('searchString' => $acn,
            'includeHistoricalDetails' => $historical_details,
            'authenticationGuid' => $this->abr_api_key
        );

        $result = $this->soap_client->call("ABRSearchByASIC",array('parameters' => $param), '', '', false, true);

        if($this->soap_client->fault)
            return null;

        if(!empty($result["ABRPayloadSearchResults"]["response"]["exception"]))
            return null;

        $abr = $this->initializeAbr($result);

        $this->abr = $abr;

        return $this;
    }

    public function isAbnValid(){
        if(!$this->abr)
            return false;
        if($this->abr->getAbnNumber())
            return true;
        return false;
    }

    public function isAcnValid($acn = null){
        if(!$this->abr)
            return false;
        if($acn){
            if($this->abr->getAcnNumber()==preg_replace("/\s/", "", $acn))
                return true;
        }else{
            if($this->abr->getAcnNumber())
                return true;
        }
        return false;
    }

    public function initializeAbr($result){

        $OutputABN = $result['ABRPayloadSearchResults']['response']['businessEntity']['ABN']['identifierValue'];
        $OutputABNStatus = $result['ABRPayloadSearchResults']['response']['businessEntity']['entityStatus']['entityStatusCode'];
        $OutputASICNumber = $result['ABRPayloadSearchResults']['response']['businessEntity']['ASICNumber'];
        $OutputEntityName = $result['ABRPayloadSearchResults']['response']['businessEntity']['mainName']['organisationName'];
        /**
         * Not all query will be returned with Trading Name
         */
        $OutputTradingName = (isset($result['ABRPayloadSearchResults']['response']['businessEntity']['mainTradingName'])) ?
            $result['ABRPayloadSearchResults']['response']['businessEntity']['mainTradingName']['organisationName']
            : $result['ABRPayloadSearchResults']['response']['businessEntity']['mainName']['organisationName'];

        $OutputOrganisationType = $result['ABRPayloadSearchResults']['response']['businessEntity']['entityType']['entityDescription'];
        $OutputState = $result['ABRPayloadSearchResults']['response']['businessEntity']['mainBusinessPhysicalAddress']['stateCode'];
        $OutputPostcode = $result['ABRPayloadSearchResults']['response']['businessEntity']['mainBusinessPhysicalAddress']['postcode'];

        $abr = new ABR();

        $abr->setAbnNumber($OutputABN);
        $abr->setStatus($OutputABNStatus);
        $abr->setAcnNumber($OutputASICNumber);
        $abr->setEntityName($OutputEntityName);
        $abr->setTradingName($OutputTradingName);
        $abr->setState($OutputState);
        $abr->setPostcode($OutputPostcode);
        $abr->setOrganisationType($OutputOrganisationType);

        return $abr;
    }
}