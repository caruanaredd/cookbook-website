<?php
    /**
     * Returns the post data, or blank if it doesn't exist.
     * @param string $name The field name.
     */
    function getPostData($name)
    {
        if (isset($_POST[$name]))
        {
            return $_POST[$name];
        }
        else
        {
            return '';
        }
    }

    /**
     * Checks if a value is empty.
     * @param string $value The input value.
     */
    function isEmpty($value)
    {
        return trim($value) == '';
    }

    /**
     * Checks if a value meets the minimum length.
     * @param string $value The input value.
     * @param int $length The string length.
     */
    function minLength($value, $length)
    {
        return strlen($value) >= $length;
    }
?>