<?php

class TrackerManager extends CApplicationComponent
{
    /**
     * @var array Tracker list with parameters
     */
    public $trackers = array();

    /**
     * @var array {@link ITracker} implementor instances
     */
    private $trackersInt;

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * Initializes the component.
     * This method is required by {@link IApplicationComponent} and is invoked by application
     * when the TrackerManager is used as an application component.
     * If you override this method, make sure to call the parent implementation
     * so that the component can be marked as initialized.
     */
    public function init()
    {
	parent::init();

	$this->trackersInt = array();

	foreach ($this->trackers as $tracker)
	{
	    $class = $tracker['class'];

	    if (!isset($class))
	    {
		throw new Exception(Yii::t('Array item with name \'class\' is not set'));
	    }
	    
	    $trackerInstance = new $class;
	    $trackerInstance->init($tracker['params']);
	    $this->trackersInt[$trackerInstance->getName()] = $trackerInstance;
	}
    }

    /**
     * Get topic watch supported tracker by its name.
     * @param string $name Tracker name
     * @return ITracker implementation or null if tracker with provided name doesn't exist.
     */
    public function getTopicTrackerByName($name)
    {
	$tracker = $this->trackersInt[$name];

	if (isset($tracker) && $tracker->actionsSupported()['topic_watch'])
	{
	    return $tracker;
	}

	return null;
    }

    /**
     * Render tracker icon.
     * @param string $trackerName Tracker name.
     * @return string String contains link to image.
     */
    public function renderTrackerIcon($trackerName)
    {
        $trackerIconFilename = $this->getTrackerIconFilename($trackerName);

        if (!isset($trackerIconFilename))
        {
	    return '<i class="icon-question-sign"></i>';
        }
        else
        {
	    return CHtml::image('/images/' . $trackerIconFilename, $trackerName, array('style'=>'width: 16px; height: 16px;'));
        }
    }

    /**
     * Retrieves tracker icon filename
     * @param string $trackerName Tracker name.
     * @return string Filename or null if tracker is not found.
     */
    private function getTrackerIconFilename($trackerName)
    {
        // get topic tracker
        $tracker = $this->getTopicTrackerByName($trackerName);

        // is it null?
        if (!isset($tracker))
        {
            return null;
        }

        return $tracker->getIconFilename();
    }

    /**
     * Get tracker name the provided url belongs to.
     * @param string $url
     * @return string tracker name if URL is supported, null otherwise
     */
    public function getTopicTrackerName($url)
    {
	foreach($this->trackersInt as $tracker)
	{
	    if ($tracker->actionsSupported()['topic_watch'] && $tracker->isMyTopic($url))
	    {
		return $tracker->getName();
	    }
	}

	return null;
    }

    /**
     * Perform logout for all topic watchable tracker.
     */
    public function logoutTopicSupported()
    {
	foreach ($this->trackersInt as $tracker)
	{
	    if ($tracker->actionsSupported()['topic_watch'] && $tracker->isLoggedIn())
	    {
		$tracker->logout();
	    }
	}
    }
}

?>