<?php

/**
 * Tracker interface.
 */
interface ITracker
{
    /**
     * Performs tracker initialization.
     * @param array $params Tracker parameters.
     */
    public function init($params);

    /**
     * Return supported actions. There are the following actions possible: subject_watch.
     * @return array Dictionary with key as action name value as whether is action supported (true) or not (false).
     * If action is absent it means action is not supported.
     */
    public function actionsSupported();

    /**
     * Check whether is provided URL belongs to tracker or not.
     * @param string $url URL to check.
     * @return boolean True if URL belongs or false if not.
     */
    public function isMySubject($url);

    /**
     * Get last modified date and time on specified subject.
     * @param string $url URL to get datetime.
     * @return mixed Subject last modified date and time or null if date and time can't be retrieved.
     */
    public function getSubjectLastUpdated($url);

    /**
     * Download torrent file and return contents on specified subject.
     * @param string $url URL to download torrent.
     * @return mixed Downloaded content or null if torrent can't be retrieved.
     */
    public function downloadSubjectTorrent($url);

    /**
     * Return human-readable tracker name. This name is used as unique identifier of the tracker.
     * @return string Tracker name.
     */
    public function getName();

    /**
     * Check whether has login been performed or not.
     * @return boolean True if performed, false otherwise.
     */
    public function isLoggedIn();

    /**
     * Perform login to the tracker.
     * @return boolean True if succeed, false otherwise.
     */
    public function login();

    /**
     * Perform logout.
     */
    public function logout();
}

?>