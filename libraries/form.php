<?php
    /**
     * Returns the file data, or false if it doesn't exist.
     * @param string $name The field name.
     */
    function getFileData($name)
    {
        if (isset($_FILES[$name]))
        {
            return $_FILES[$name];
        }
        else
        {
            return false;
        }
    }

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
     * Checks if a file is an image.
     * @param array $file The uploaded file.
     */
    function isImage($file)
    {
        // If there is no file, return false (not an image).
        if (!$file || $file['name'] == '') return false;
        
        // Returns true if the image type is a number, or false if not.
        return exif_imagetype($file['tmp_name']) != false;
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