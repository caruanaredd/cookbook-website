<?php
    // The email encryption key for our database.
    define('AES_ENCRYPT_KEY', 'canttouchthis');

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
     * Edits a cuisine.
     * @param int $id The cuisine ID.
     * @param string $name The cuisine name.
     */
    function editCuisine($id, $name)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Generate a query and prepare it for data insertion
        // using the mysqli library; this takes care of any
        // potential hacking (SQL Injection).
        $stmt = mysqli_prepare($link, "
            UPDATE cuisine
            SET name = ?
            WHERE cuisineID = ?
        ");

        // 3. Bind the parameters to ensure that strings and numbers
        // will be escaped to avoid errors in PHP code.
        mysqli_stmt_bind_param($stmt, 'si',
            $name,          # string
            $id             # integer
        );

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have 0 or 1 updated rows.
        return mysqli_stmt_affected_rows($stmt) != -1;
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

    // -------------------------------------------------------------------------
    // Levels Table Management
    // -------------------------------------------------------------------------
    /**
     * Retrieves all levels from the table.
     */
    function getAllLevels()
    {
        // 1. Connect to the database.
        $link = connect();
        
        // 2. Process a query and store the result in a variable.
        $result = mysqli_query($link, "
        SELECT *
        FROM levels
        ");
        
        // 3. Close the connection.
        disconnect($link);
        
        // 4. Return the result or a false if the query failed.
        return $result ?: false;
    }

    // -------------------------------------------------------------------------
    // Recipe Table Management
    // -------------------------------------------------------------------------
    /**
     * Adds the basic recipe information.
     * @param $title The recipe title.
     * @param $description The recipe description.
     * @param $prepTime The preparation time in minutes.
     * @param $cookTime The cook time in minutes.
     * @param $additionalTime The additional time in minutes.
     * @param $yields The yield value.
     * @param $levelID The level ID.
     * @param $cuisineID The cuisine ID.
     */
    function addRecipe($title, $description, $prepTime, $cookTime, $additionalTime, $yields, $levelID, $cuisineID)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Prepare a query using the mysqli library
        // to take care of any potential hacking.
        $stmt = mysqli_prepare($link, "
            INSERT INTO recipe
                (title, description, prepTime, cookTime, additionalTime, yields, levelID, cuisineID, creationDate)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $time = time();

        // 3. Binding parameters will ensure any characters
        // will be escaped without us putting the work.
        mysqli_stmt_bind_param($stmt, 'ssiiiiiii',
            $title,             # string
            $description,       # string
            $prepTime,          # integer
            $cookTime,          # integer
            $additionalTime,    # integer
            $yields,            # integer
            $levelID,           # integer
            $cuisineID,         # integer
            $time               # integer
        );

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    // -------------------------------------------------------------------------
    // User Management
    // -------------------------------------------------------------------------
    /**
     * Registers a user.
     * @param $username The username.
     * @param $email The email address.
     * @param $password The unfiltered password.
     * @param $saltLength The length of the salt string.
     */
    function registerUser($username, $email, $password, $saltLength = 8)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Process the information we need to protect the user data.
        // Generate a salt string.
        $salt = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($saltLength / strlen($x)))), 1, $saltLength);

        // Encrypt the password.
        $password = password_hash($password.$salt, CRYPT_BLOWFISH);

        // Convert the constant/integer values to a variable.
        $key = AES_ENCRYPT_KEY;
        $groupID = 16;

        // 3. Generate a query and prepare it for data insertion
        // using the mysqli library; this takes care of any
        // potential hacking (SQL Injection).
        $stmt = mysqli_prepare($link, "
            INSERT INTO users
                (username, email, password, salt, groupID)
            VALUES
                (?, HEX(AES_ENCRYPT(?, ?)), ?, ?, ?)
        ");

        // 4. Bind the parameters to ensure that strings and numbers
        // will be escaped to avoid errors in PHP code.
        mysqli_stmt_bind_param($stmt, 'sssssi',
            $username,              # string
            $email,                 # string
            $key,                   # string
            $password,              # string
            $salt,                  # string
            $groupID                # integer
        );

        // 5. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 6. Disconnect from the database.
        disconnect($link);

        // 7. If the query worked, we should have a new primary key ID.
        return mysqli_stmt_insert_id($stmt);
    }

    /**
     * Registers the user's meta information.
     * @param $userID The user ID.
     * @param $name The user's name.
     * @param $surname The user's surname.
     */
    function registerUserMeta($userID, $name, $surname)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Generate a query and prepare it for data insertion
        // using the mysqli library; this takes care of any
        // potential hacking (SQL Injection).
        $stmt = mysqli_prepare($link, "
            INSERT INTO userMeta
                (userID, firstName, lastName)
            VALUES
                (?, ?, ?)
        ");

        // 3. Bind the parameters to ensure that strings and numbers
        // will be escaped to avoid errors in PHP code.
        mysqli_stmt_bind_param($stmt, 'iss',
            $userID,        # integer
            $name,          # string
            $surname        # string
        );

        // 4. Execute the statement.
        mysqli_stmt_execute($stmt);

        // 5. Disconnect from the database.
        disconnect($link);

        // 6. If the query worked, we should have a new affected row.
        return mysqli_stmt_affected_rows($stmt) > 0;
    }

    /**
     * Attempts to log a user into the system.
     * @param $login The username or email.
     * @param $password The unfiltered password.
     */
    function login($login, $password)
    {
        // 1. Try to get the user's password information.
        $user = getUserCredentials($login);

        // 2. If the user was not found, we can stop here.
        if (!$user) return false;

        // 3. Try to validate the password.
        if (!password_verify($password.$user['salt'], $user['password'])) return false;

        // 4. Return the user data for login purposes.
        return getUserDetails($user['userID']);
    }

    /**
     * Retrieves the ID and password information for a user's login details.
     * @param $login The username or registered email.
     */
    function getUserCredentials($login)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variable to avoid any SQL Injection.
        $login      = mysqli_real_escape_string($link, $login);
        $key        = mysqli_real_escape_string($link, AES_ENCRYPT_KEY);

        // 3. Process a query and store the result in a variable.
        $result = mysqli_query($link, "
            SELECT userID, salt, password
            FROM users
            WHERE username = '{$login}' OR email = HEX(AES_ENCRYPT('{$login}', '{$key}'))
        ");

        // 4. Close the connection.
        disconnect($link);

        // 5. Return the result or a false if the query failed.
        return mysqli_fetch_assoc($result) ?: false;
    }

    /**
     * Returns the user's readable information.
     * @param $userID The user's ID in the table.
     */
    function getUserDetails($userID)
    {
        // 1. Connect to the database.
        $link = connect();

        // 2. Protect the variable to avoid any SQL Injection.
        $userID      = mysqli_real_escape_string($link, $userID);

        // 3. Process a query and store the result in a variable.
        $result = mysqli_query($link, "
            SELECT a.userID, a.username, a.groupID, b.firstName, b.lastName
            FROM users a
            LEFT JOIN userMeta b
                ON a.userID = b.userID
            WHERE a.userID = {$userID}
        ");

        // 4. Close the connection.
        disconnect($link);

        // 5. Return the result or a false if the query failed.
        return mysqli_fetch_assoc($result) ?: false;
    }
?>