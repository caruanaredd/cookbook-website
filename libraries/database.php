<?php
    // -------------------------------------------------------------------------
    // Database Connection
    // -------------------------------------------------------------------------
    /**
     * Connects to a MySQL database.
     */
    function connect()
    {
        // 1. Assign a new connection to a new variable
        // or kill the process if it fails.
        $link = mysqli_connect('localhost', 'root', '', 'cookbook')
            or die('Could not connect to the database.');

        // 2. Give back the variable so we can use it.
        return $link;
    }

    /**
     * Closes the connection to the database.
     * @param mysqli $link The active database connection.
     */
    function disconnect(&$link)
    {
        mysqli_close($link);
    }

    // -------------------------------------------------------------------------
    // Cuisine Table Management
    // -------------------------------------------------------------------------
    /**
     * Adds a cuisine.
     * @param string $name The cuisine name.
     */
    function addCuisine($name)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Generate a query and prepare it for data insertion
        // using the mysqli library; this takes care of any
        // potential hacking (SQL Injection).
        $stmt = mysqli_prepare($link, "
            INSERT INTO cuisine
                (name)
            VALUES
                (?)
        ");

        // 3. Bind the parameters to ensure that strings and numbers
        // will be escaped to avoid errors in PHP code.
        mysqli_stmt_bind_param($stmt, 's',
            $name           # string
        );

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    /**
     * Deletes a cuisine.
     * @param string $cuisineID The cuisine id.
     */
    function deleteCuisine($cuisineID)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Generate a query and prepare it for data insertion
        // using the mysqli library; this takes care of any
        // potential hacking (SQL Injection).
        $stmt = mysqli_prepare($link, "
            DELETE FROM cuisine
            WHERE cuisineID = ?
        ");

        // 3. Bind the parameters to ensure that strings and numbers
        // will be escaped to avoid errors in PHP code.
        mysqli_stmt_bind_param($stmt, 'i',
            $cuisineID          # integer (whole number)
        );

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have one deleted row.
        return mysqli_stmt_affected_rows($stmt) == 1;
    }

    /**
     * Retrieves all cuisines from the table.
     */
    function getAllCuisines()
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Process a query and store the result in a variable.
        $result = mysqli_query($link, "
            SELECT *
            FROM cuisine
            ORDER BY name ASC
        ");

        // 3. Close the connection.
        disconnect($link);

        // 4. Return the result or a false if the query failed.
        return $result ?: false;
    }

    /**
     * Retrieves a cuisine from the table.
     * @param integer $cuisineID The cuisine ID.
     */
    function getCuisine($cuisineID)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variable to avoid any SQL Injection.
        $cuisineID = mysqli_real_escape_string($link, $cuisineID);

        // 3. Process a query and store the result in a variable.
        $result = mysqli_query($link, "
            SELECT *
            FROM cuisine
            WHERE cuisineID = {$cuisineID}
        ");

        // 4. Close the connection.
        disconnect($link);

        // 5. Return the result or a false if the query failed.
        return mysqli_fetch_assoc($result) ?: false;
    }
?>