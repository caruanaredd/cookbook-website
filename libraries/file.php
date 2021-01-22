<?php
    /**
     * Checks that a directory exists, and creates it if it doesn't.
     * @param string $path The folder path.
     */
    function checkDirectory($path)
    {
        // 1. Split the path into components (folder names).
        $folders = explode('/', $path);

        // 2. Start with the first array element.
        $folder = reset($folders);

        // 3. Overwrite $path so that we can create one folder at a time.
        $path = $folder;

        while ($folder != null)
        {
            // We don't need to create dot or empty folders.
            if ($folder != '.' && $folder != '..' && $folder != '')
            {
                // If the path doesnt exist or is not a directory, create the folder.
                if (!file_exists($path) || !is_dir($path))
                {
                    // Create the folder.
                    mkdir($path);

                    // Set its permissions.
                    chmod($path, 0777);
                }
            }

            // Move to the next folder until the end.
            $folder = next($folders);
            $path .= "/{$folder}";
        }
    }

    /**
     * Uploads a file to a path.
     * @param array $file The file input.
     * @param string $path The folder path.
     * @param string $name The new file name.
     */
    function uploadFile($file, $path, $name)
    {
        // $file -> form input
        // $path -> folder path
        // $name -> "3", "hello"

        // Do not upload if there are no files.
        if (!$file || $file['name'] == '') return true;

        // Check that the directory exists.
        checkDirectory($path);

        // Check that there are no other files with the same name.
        // If so, delete them.
        $images = glob("{$path}/{$name}.*");
        foreach ($images as $image) unlink($image);

        // Get the file details and extract its extension.
        $details = pathinfo($file['name']);
        $ext = $details['extension'];

        // Compile the path and move the file in place.
        $path .= "/{$name}.{$ext}";
        return move_uploaded_file($file['tmp_name'], $path);
    }

    function getImage($path)
    {
        // ex: $path -> uploads/recipe/13
        $images = glob("{$path}.*");
        
        if (count($images) > 0) return $images[0];
        return 'uploads/not-found.png';
    }