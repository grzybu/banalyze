<?php
/**
 * Created by JetBrains PhpStorm.
 * User: grzybu
 * Date: 07.08.12
 * Time: 22:44
 * To change this template use File | Settings | File Templates.
 */
class Abby_OcrSdk
{
    protected $_applicationId;
    protected $_password;
    protected $_url;




    public function setApplicationId($applicationId)
    {
        $this->_applicationId = $applicationId;
    }

    public function getApplicationId()
    {
        return $this->_applicationId;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @return Zend_Http_Client
     */
    public function getHttpClient()
    {


            $config = array(
                'adapter' => 'Zend_Http_Client_Adapter_Curl',
                'curloptions' => array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_USERPWD => $this->getApplicationId() . ":" . $this->getPassword(),
                    CURLOPT_POST => true,
                )
            );

            $client = new Zend_Http_Client();
            $client->setConfig($config);
            $client->setCookieJar(true);
            $client->setAuth($this->getApplicationId(), $this->getPassword());
         return $client;


    }

    /**
     * The method loads the image, creates a processing task for the image
     * with the specified parameters, and passes the task for processing.
     *
     * @param string $image Image location
     * @param string $exportFormat
     * @return string
     */
    public function processImage($image, $exportFormat = 'xlsx')
    {
        if(!file_exists($image)) {
            throw new Exception("Brak pliku");
        }

        $client = $this->getHttpClient();
        $client->setUri("http://cloud.ocrsdk.com/processImage?language=polish&exportFormat={$exportFormat}");

        $client->setFileUpload($image, 'my_file');
        $response = $client->request(Zend_Http_Client::POST);

        $xml = simplexml_load_string($response->getBody());

        return (string)$xml->task->attributes()->id;

    }

    public function getTaskStatus($taskId)
    {
        $client = $this->getHttpClient();
        $client->setMethod(Zend_Http_Client::GET);
        $client->setUri("http://cloud.ocrsdk.com/getTaskStatus" . "?taskid={$taskId}");

        $response = $client->request(Zend_Http_Client::GET);

        $xml = simplexml_load_string($response->getBody());

        $status = (string) $xml->task->attributes()->status;

        if($status == 'Completed') {
            return array('status' => $status, 'resultUrl' => (string) $xml->task->attributes()->resultUrl);
        }else {
            return $status;
        }





    }
}
