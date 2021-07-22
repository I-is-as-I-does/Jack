<?php 
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Object {

            
    public function loadClass($className, $classArg = []){
        if (class_exists($className, true)){
            return new $className(...$classArg);
        }
      return false;    
    }

    public function callMethod($classObj, $methodName, $methodArg= []){
        if(is_object($classObj) && method_exists($classObj, $methodName)){
            return $classObj->$methodName(...$methodArg);
        }
        return false;
    }

    public function getSubClass($classObj, $subClassPartName, $subArg = [])
    {
        if(is_object($classObj){
        $classInfos = new \ReflectionClass($classObj);
        $prop = $this->getSubClassPropName($classInfos, $subClassPartName);
        if (\property_exists($classObj, $prop)) {
            if (empty($classObj->$prop)) {
                $subClassName = $this->getSubClassName($classInfos,$prop);
                $classObj->$prop = $this->loadClass($subClassName, $subArg); 
            }
            return $classObj->$prop;
        }
    }
        return false;
}

    public function getSubClassPropName($classInfos, $subClassPartName){
        return $classInfos->getShortName() . $subClassPartName;
    }

    public function getSubClassName($classInfos,$subClassPropName)
    {
        return $classInfos->getNamespaceName() . '\\'.$subClassPropName;
    }

    public function getSubClassMethod($classObj, $subClassName, $methodName, $methodArg= [])
    {
        if(is_object($classObj) && property_exists($classObj, $methodName)){
            return $classObj->$subClassName->$methodName(...$methodArg);
        }
        return false;
    }


}