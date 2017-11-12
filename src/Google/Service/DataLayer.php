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
        $this->data = array_merge($this->data, $data);
    }

    /**
     * Get the actual script tag with the current data in it
     *
     * @return string
     */
    public function getDataLayerScript()
    {
        $data = json_encode(empty($this->data) ? [] : [$this->data]);
        return "<script>dataLayer = {$data};</script>";
    }
}
