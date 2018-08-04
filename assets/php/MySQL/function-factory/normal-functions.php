<?php

    // Check if there is a duplicate entry in the database from a predefined value, column, and table
    function duplicateEntry($conn, $value, $column, $table){
        $sql = "SELECT count(*) as count FROM {$table}
                    WHERE {$column} = '{$value}'";
        $result = mysqli_query($conn, $sql);
        return ($result->fetch_assoc()["count"] > 0 ? TRUE : FALSE);
    }
?>