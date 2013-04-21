<?php

/**
 * Rutracker implementation of {@link ITracker} interface.
 */
class RutrackerTracker implements ITracker
{
    /**
     * @var string Username for login.
     */
    private $username;

    /**
     * @var string Password for login.
     */
    private $password;

    /**
     * Performs tracker initialization.
     * @param array $params Tracker parameters. Params should contain: username and password.
     */
    public function init($params)
    {
	$this->username = $params['username'];
	$this->password = $params['password'];
    }

    /**
     * Return supported actions.
     * @return array Dictionary with key as action name value as whether is action supported (true) or not (false).
     */
    public function actionsSupported()
    {
	return array('subject_watch' => true);
    }

    /**
     * Check whether is provided URL belongs to tracker or not.
     * @param string $url URL to check.
     * @return boolean True if URL belongs or false if not.
     */
    public function isMySubject($url)
    {
	return true;
    }

    /**
     * Get last modified date and time on specified subject.
     * @param string $url URL to get datetime.
     * @return mixed Subject last modified date and time or null if date and time can't be retrieved.
     */
    public function getSubjectLastUpdated($url)
    {

    }

    /**
     * Download torrent file and return contents on specified subject.
     * @param string $url URL to download torrent.
     * @return mixed Downloaded content or null if torrent can't be retrieved.
     */
    public function downloadSubjectTorrent($url)
    {

    }

    /**
     * Return human-readable tracker name ('rutracker.org'). This name is used as unique identifier of the tracker.
     * @return string Tracker name.
     */
    public function getName()
    {
	return 'rutracker.org';
    }

    /**
     * Check whether has login been performed or not
     * @return boolean True if performed, false otherwise.
     */
    public function isLoggedIn()
    {

    }

    /**
     * Perform login to the tracker.
     * @return boolean True if succeed, false otherwise.
     */
    public function login()
    {

    }

    /**
     * Perform logout.
     */
    public function logout()
    {

    }
}

?>