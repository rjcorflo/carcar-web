<?php

namespace App\Google\Service;

class DataLayer
{

    /** @var array */
    protected $data = [];
    /**
     * Push an array to the DataLayer
     *
     * @param array $data
     */
    public function pushDataArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->pushData($key, $value);
        }
    }
    /**
     * Push a single key and value to the DataLayer
     *
     * @param string $key
     * @param string $value
     */
    public function pushData($key, $value = '')
    {
        if (isset($key) && !empty($key)) {
            // we should allow empty values in datalayer
            $this->data[$key] = $value;
        }
    }
    /**
     * Get the actual script tag with the current data in it
     *
     * @return string
     */
    public function getDataLayerScript()
    {
        $data = json_encode($this->data);
        return "<script>dataLayer = {$data} ;</script>";
    }
    /**
     * Convert data array to string
     */
    private function arrayToString($data)
    {
        if (empty($data)) {
            return '';
        }
        // base of datalayer
        $data_layer = '';
        // through the data and create the DataLayer string
        foreach ($data as $key => $value) {
            $data_layer .= "'${key}': '" . htmlentities($value, ENT_QUOTES) . "',";
        }
        // Remove last comma
        $data_layer = substr($data_layer, 0, -1);
        return $data_layer;
    }
}