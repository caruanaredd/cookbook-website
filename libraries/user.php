<?php
    /**
     * Checks that a user has the required permission.
     * @param $groupID The user's current group.
     * @param $permission The desired permission value.
     */
    function hasPermission($groupID, $permission)
    {
        return ($permission & $groupID) == $groupID;
    }

    /**
     * VERY simplistic check to make sure a user is logged in.
     */
    function isLoggedIn()
    {
        return isset($_COOKIE['userID']) && isset($_COOKIE['groupID']);
    }