<?php

    //Check is value is a blank value
    function isBlank($value){
        return $value == "";
    }

    //check if this is part of a valid input group
    function validInputGroup($value, $options){
        return in_array($value, $options);
    }

    //check if input is a number
    function validNumberInput($value){
        return is_numeric($value);
    }

    //check if array has valid keys
    /*
     * this_array refers to array with key values
     * group is the key values that must be present
     * values are the acceptable values with a blank array being universal
     */
    function validKeyGroup($this_array, $group, $values){
        $valid = TRUE;
        $valid = (is_array($this_array) ? TRUE : FALSE);

        for($i = 0; $i < count($this_array); $i++){
            for($ii = 0; $ii < count($group); $ii++){
                if($valid == FALSE){
                    return $valid;
                }
                
                $valid = (array_key_exists($group[$ii], $this_array[$i]) ? TRUE : FALSE);

                if(count($values[$ii]) > 0 && $valid){
                    $valid = (validInputGroup($this_array[$i][$group[$ii]], $values[$ii]) ? TRUE : FALSE);
                }
            }
        }

        return $valid;
    }

    //check if criteria matches all defined rules
    function validCriteria($criteria, $rules, $def){
        $ready = TRUE;
        $ready = (is_array($criteria) ? TRUE : FALSE);
        for($i = 0; $i < count($criteria); $i++){
            if($ready == FALSE){
                return $ready;
            }
            else{
                if(array_key_exists("column", $criteria[$i]) && array_key_exists("rule", $criteria[$i]) && array_key_exists("value", $criteria[$i])){
                    if(array_key_exists($criteria[$i]["column"], $def)){
                        $ready = (validInputGroup($criteria[$i]["rule"], $rules[$def[$criteria[$i]["column"]]]) ? TRUE : FALSE);
                    }
                    else{
                        $ready = FALSE;
                    }
                }
                else{
                    $ready = FALSE;
                }
            }
        }

        return $ready;
    }
?>