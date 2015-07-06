<?php
/**
 * Created by PhpStorm.
 * User: Olaniyi
 * Date: 3/2/15
 * Time: 11:51 AM
 */

class LabelList {
    private $list;

    public function __construct(){
        $this->list = array();
    }

    /**
     * @param $label_node LabelNode
     * @return bool
     */
    public function addNode($label_node){
        if (isset($this->list[$label_node->getId()])){
            return false;
        }
        $this->list[$label_node->getId()] = $label_node;
        return true;
    }

    public function deleteNode($label_id){
        if (isset($this->list[$label_id])){
            unset($this->list[$label_id]);
            return true;
        }
        return false;
    }

    public function getNode($label_id){
        return (isset($this->list[$label_id])) ? $this->list[$label_id] : NULL;
    }

    public function updateNode($label_id, $label_name, $label_attribute = NULL){
        if (isset($this->list[$label_id])){
            $this->list[$label_id]->setLabel($label_name);
            $this->list[$label_id]->setAttribute($label_attribute);
            return true;
        }
        return false;
    }

    public function getList(){
        return $this->list;
    }

    public function clearList(){
        $this->list = array();
    }
}

class LabelNode {
    private $label;
    private $id;
    private $attribute;

    public function __construct($label, $id, $attribute = NULL){
        $this->label = trim($label);
        $this->id = $id;
        $this->attribute = $attribute;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }
}