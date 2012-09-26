<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 11.09.12
 * Time: 23:31
 * To change this template use File | Settings | File Templates.
 */
class Application_Model_Result extends Application_Model_AbstractModel
{

    protected $_dbTableName = 'Results';

    /* @var Application_Model_Patient contains Patient object */
    protected $_patient;

    protected $_patient_id;
    protected $_rbc;
    protected $_hct;
    protected $_hgb;
    protected $_mchc;
    protected $_mcv;
    protected $_mch;
    protected $_wbc;



    /**
     * @param \Application_Model_Patient $patient
     */
    public function setPatient($patient)
    {
        $this->_patient_id = $patient->id;
        $this->_patient = $patient;
    }

    /**
     * @return \Application_Model_Patient
     */
    public function getPatient()
    {
        return $this->_patient;
    }

    public function save(){

        if(null == $this->_patient) throw new Exception("Patient must be set");




        return parent::save();
    }

    public function setHct($hct)
    {
        $this->_hct = $hct;
    }

    public function getHct()
    {
        return $this->_hct;
    }

    public function setHgb($hgb)
    {
        $this->_hgb = $hgb;
    }

    public function getHgb()
    {
        return $this->_hgb;
    }

    public function setRbc($rbc)
    {
        $this->_rbc = $rbc;
    }

    public function getRbc()
    {
        return $this->_rbc;
    }

    public static function calcMCHC($hgb,$htc)
    {
        return $hgb * 100/$htc;
    }

    public static function calcMCV($htc,$rbc) {
        return $htc *10/$rbc;
    }

    public static function calcMCH($hgb, $rbc){
        return $hgb * 10/$rbc;
    }

    public function setMchc($mchc)
    {
        $this->_mchc = $mchc;
    }

    public function getMchc()
    {
        return $this->_mchc;
    }

    public function setWbc($wbc)
    {
        $this->_wbc = $wbc;
    }

    public function getWbc()
    {
        return $this->_wbc;
    }

    public function setMch($mch)
    {
        $this->_mch = $mch;
    }

    public function getMch()
    {
        return $this->_mch;
    }

    public function setMcv($mcv)
    {
        $this->_mcv = $mcv;
    }

    public function getMcv()
    {
        return $this->_mcv;
    }

    public function getBySex($sex = null, $limit = 10){
        $table = $this->getDbTable();

        $where = $table->select()
                        ->limit($limit)
                        ->order(new Zend_Db_Expr("RAND()"));
        if($sex && in_array($sex, "M", "K")) $where->where("sex = ?", $sex);

        return $table->fetchAll($where);


    }


}
