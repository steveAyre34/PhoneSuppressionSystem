<?php
    require('../function-factory/error-functions.php');
    require('../function-factory/normal-functions.php');
    require('../../MySQL/phone.php');

    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":

            $criteria_rules = array(
                "String" => array(
                    "contains",
                    "exact"
                ),
                "Date" => array(
                    "greater",
                    "less",
                    "exact"
                )
            );

            $criteria_def = array(
                "name" => "String",
                "phone" => "String",
                "type" => "String",
                "date_added" => "Date"
            );

            //Check any missing data headers
            $page = $_GET["page"] or dataHeaderError("page");
            $limit = $_GET["limit"] or dataHeaderError("limit");
            $column = $_GET["column"] or dataHeaderError("column");
            $sort = $_GET["sort"] or dataHeaderError("sort");
            $strict = $_GET["strict"] or dataHeaderError("strict");
            $criteria = $_GET["criteria"] or dataHeaderError("criteria");

            //Normal error checks
            (!isBlank($page) ? $page = $_GET["page"] : valueError("page"));
            (validNumberInput($page) ? $page = $_GET["page"] : valueError("page"));
            (!isBlank($limit) ? $limit = $_GET["limit"] : valueError("limit"));
            (validNumberInput($limit) ? $limit = $_GET["limit"] : valueError("limit"));
            (validInputGroup($column, array("name", "phone", "type", "dated_added")) ? $column = $_GET["column"] : valueError("column"));
            (validInputGroup($sort, array("ASC", "DESC")) ? $sort = $_GET["sort"] : valueError("sort"));
            (validInputGroup($strict, array(1, 2)) ? $strict = $_GET["strict"] : valueError("strict"));
            (validCriteria($criteria, $criteria_rules, $criteria_def) ? $criteria = $_GET["criteria"] : valueError("criteria"));

           //Proceed with SQL
            echo json_encode(getPhones(array(
                "page" => $page,
                "limit" => $limit,
                "column" => $column,
                "sort" => $sort,
                "strict" => $strict,
                "criteria" => $criteria
            )));
            break;
        default: 
            requestMethodError();
            break;
    }
?>