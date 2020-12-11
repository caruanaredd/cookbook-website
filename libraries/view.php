<?php
    /**
     * The current section being processed.
     */
    $vCurrentSection = null;

    /**
     * The layout to be used.
     */
    $vLayout = null;

    /**
     * The sections available for print.
     */
    $vSections = [];

    /**
     * Stops processing the buffer content.
     */
    function endSection()
    {
        // Tells PHP that we're using a predefined global variable.
        global $vCurrentSection, $vSections;

        // Get the contents of the buffer and clear it for future use.
        $content = ob_get_clean();
        
        // If the current section has not been set, stop the page from processing.
        if (!isset($vCurrentSection))
            exit("Section was not defined.");
        
        // If the current section was not previously defined, we need to create it.
        if (!array_key_exists($vCurrentSection, $vSections))
            $vSections[$vCurrentSection] = [];
        
        // Add the content to the sections array and clear the current one.
        $vSections[$vCurrentSection][] = $content;
        $vCurrentSection = null;
    }

    /**
     * Prepares a layout for use by the buffer.
     * @param string $path The file path.
     */
    function extend($path)
    {
        // Tells PHP that we're using a predefined global variable.
        global $vLayout;

        // Only load the file if it exists.
        if (file_exists($path)) $vLayout = $path;
        else exit("The layout file could not be loaded: {$path}");
    }

    /**
     * Outputs the layout.
     */
    function output()
    {
        // Tells PHP that we're using a predefined global variable.
        global $vLayout;

        // This is the variable through which we will output.
        $content = '';

        // Process the layout if everything is in order (layout is not null and file exists).
        if ($vLayout != null && file_exists($vLayout))
        {
            // Start the buffer
            ob_start();
            
            // Insert the layout and save it to the content variable.
            include $vLayout;
            $content = ob_get_contents();

            // Clean the output and suppress any errors.
            @ob_end_clean();
        }

        echo $content;
    }

    /**
     * Finds the section in the array and prints it.
     * @param string $name The section name.
     */
    function renderSection($name)
    {
        // Tells PHP that we're using a predefined global variable.
        global $vSections;

        // Do nothing if the section doesn't exist.
        if (!array_key_exists($name, $vSections))
        {
            echo '';
            return;
        }

        // Loop through all the content and print it.
        foreach ($vSections[$name] as $key => $content)
        {
            echo $content;
            // deletes the content that was just printed from the array.
            unset($vSections[$name][$key]);
        }
    }

    /**
     * Starts processing the buffer content.
     * @param string $name The section name.
     */
    function startSection($name)
    {
        // Tells PHP that we're using a predefined global variable.
        global $vCurrentSection;
        
        // Set the current section and start processing the content.
        $vCurrentSection = $name;
        ob_start();
    }
?>