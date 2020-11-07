<?php


namespace Frisby\Service;


use Frisby\Framework\Singleton;

class Validation extends Singleton
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function custom(\Closure $fn){
        return call_user_func($fn,$this->data);
    }
    public function required($data)
    {
        return !(is_null($this->data) || empty($this->data));
    }

    public function unique($data){
        $get = Database::GetDataByColumn($data['table'],$data['column'],$this->data);
        return is_array($get) ? count($get) < 1 : true;
    }

    public function max($limit)
    {
        return strlen($this->data) <= $limit;
    }

    public function min($limit)
    {
        return strlen($this->data) >= $limit;
    }

    public function range($min, $max)
    {
        return $this->min($min) && $this->max($max);
    }

    public function minValue($limit){
        return $this->data >= $limit;
    }

    public function maxValue($limit){
        return $this->data <= $limit;
    }

    public function equals($data){
        return $this->data == $data;
    }

    public function string($data)
    {
        return is_string($data);
    }

    public function int($data)
    {
        return is_int($data);
    }


}