<?php

/**
 * Rutracker implementation of {@link ITracker} interface.
 */
class RutrackerTracker implements ITracker
{
    /**
     * Regex topic
     */
    const TOPIC_REGEX = '!http://rutracker\.org/forum/viewtopic\.php\?t=(\d+)!';

    /**
     * User agent
     */
    const USER_AGENT = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; ru; rv:1.9.2.4) Gecko/20100611 Firefox/3.6.4';

    /**
     * @var string Username for login.
     */
    private $username;

    /**
     * @var string Password for login.
     */
    private $password;

    /**
     * @var string Stored cookies to interact with tracker.
     */
    private $cookie = null;

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
	return array('topic_watch' => true);
    }

    /**
     * Check whether is provided URL belongs to tracker or not.
     * @param string $url URL to check.
     * @return boolean True if URL belongs or false if not.
     */
    public function isMyTopic($url)
    {
	return preg_match(self::TOPIC_REGEX, $url);
    }

    /**
     * Get last modified date and time on specified topic.
     * @param string $url URL to get datetime.
     * @return mixed Topic last modified date and time.
     * @exception Exception thrown when something goes wrong.
     */
    public function getTopicLastUpdated($url)
    {
	$page = $this->getContent($url);

	if (empty($page))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get topic last updated date time:') . ' ' . Yii::t('components_RutrackerTracker','page is empty'));
	}

	if (!preg_match('/<span title="Когда зарегистрирован">\[ (.+) \]<\/span>/', $page, $array))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get topic last updated date time:') . ' ' . Yii::t('components_RutrackerTracker','cannot find torrent registered date and time'));
	}

	if (!isset($array[1]) || empty($array[1]))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get topic last updated date time:') . ' ' . Yii::t('components_RutrackerTracker','datetime field is not set or empty'));
	}

	return $this->dateStringToNum($array[1]);
    }

    /**
     * Download torrent file and return contents on specified topic.
     * @param string $url URL to download torrent.
     * @return mixed Downloaded content.
     * @exception Exception thrown when something goes wrong.
     */
    public function downloadTopicTorrent($url)
    {
	if (!isset($this->cookie))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t download torrent:') . ' ' . Yii::t('components_RutrackerTracker','not logged in'));
	}

	$topicId = $this->getTopicId($url);

	if (!isset($topicId))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t download torrent:') . ' ' . Yii::t('components_RutrackerTracker','cannot get topic id'));
	}

	$topicId =  urlencode($topicId);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://dl.rutracker.org/forum/dl.php?t=' . $topicId);
	curl_setopt($ch, CURLOPT_COOKIE, $this->cookie.'; bb_dl=' . $topicId);
	curl_setopt($ch, CURLOPT_REFERER, 'http://dl.rutracker.org/forum/dl.php?t=' . $topicId);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 't=' . $topicId);
	$result = curl_exec($ch);
	curl_close($ch);
	
	return $result;
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
     * Check whether has login been performed or not.
     * @return boolean True if performed, false otherwise.
     */
    public function isLoggedIn()
    {
	return isset($cookie);
    }

    /**
     * Perform login to the tracker.
     * @exception Exception thrown when something goes wrong.
     */
    public function login()
    {
	if ($this->isLoggedIn())
	{
	    $this->logout();
        }

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, 'http://login.rutracker.org/forum/login.php');
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'login_username=' . urlencode($this->username) . '&login_password=' . urlencode($this->password) . '&login=%C2%F5%EE%E4');
	$result = curl_exec($ch);
	curl_close($ch);
	
	$page = iconv('windows-1251', 'utf-8', $result);
	$this->cookie = $this->getCookie($page);
    }

    /**
     * Perform logout.
     */
    public function logout()
    {
	// TODO: perform logout
	$this->cookie = null;
    }

    /**
     * Get cookie from login page.
     * @param string $page Page to parse.
     * @return Cookies or null if something wrong.
     * @exception Exception thrown when something goes wrong.
     */
    private function getCookie($page)
    {
	if (empty($page))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get cookie:') . ' ' . Yii::t('components_RutrackerTracker','page is empty'));
	}

        if (preg_match('/profile\.php\?mode=register/', $page, $array))
        {
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get cookie:') . ' ' . Yii::t('components_RutrackerTracker','wrong credentials'));
        }

        if (!preg_match('/bb_data=(.+);/iU', $page, $array))
        {
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get cookie:') . ' ' . Yii::t('components_RutrackerTracker','cookie not found'));
	}

        return 'bb_data='.$array[1].';';
    }

    /**
      * Load topic page by specified URL.
      * @param string $url URL to load from.
      * @return string content or null if something wrong.
      * @exception Exception thrown when something goes wrong.
      */
    private function getContent($url)
    {
	if (!isset($this->cookie))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get content:') . ' ' . Yii::t('components_RutrackerTracker','not logged in'));
	}

	$topicId = $this->getTopicId($url);

	if (!isset($topicId))
	{
	    throw new Exception(Yii::t('components_RutrackerTracker','Can\'t get content:') . ' ' . Yii::t('components_RutrackerTracker','cannot get topic id'));
	}

	$topicId =  urlencode($topicId);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://rutracker.org/forum/viewtopic.php?t=' . $topicId);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$header[] = "Host: rutracker.org\r\n";
	$header[] = 'Content-length: '.strlen($this->cookie)."\r\n\r\n";
	curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	$result = curl_exec($ch);
	curl_close($ch);

	$result = iconv('windows-1251', 'utf-8', $result);
	return $result;
    }

    /**
     * Extract topic id from specified URL.
     * @param string $url URL to parse from.
     * @return string Topic id.
     */
    private function getTopicId($url)
    {
        if (preg_match(self::TOPIC_REGEX, $url, $array))
	{
	    return $array[1];
	}

	return null;
    }

    /**
     * Convert rutracker date time to string.
     * @param string $data string to parse.
     * @return timestamp Extracted date and time.
     */
    private function dateStringToNum($data)
    {
	$monthes = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
	$month = substr($data, 3, 6);
	$date = preg_replace('/(\d\d)-(\d\d)-(\d\d)/', '$3-$2-$1', str_replace($month, str_pad(array_search($month, $monthes)+1, 2, 0, STR_PAD_LEFT), $data));
	$date = date('Y-m-d H:i:s', strtotime($date));
	
	return $date;
    }
}

?>