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
		throw new CException(Yii::t('Array item with name \'class\' is not set'));
	    }
	    
	    $trackerInstance = new $class;
	    $trackerInstance->init($tracker['params']);
	    $this->trackersInt[$trackerInstance->getName()] = $trackerInstance;
	}
    }

    /**
     * Get tracker name the provided url belongs to.
     * @param string $url
     * @return string tracker name if URL is supported, null otherwise
     */
    public function getSubjectTrackerName($url)
    {
	foreach($this->trackersInt as $tracker)
	{
	    if ($tracker->actionsSupported()['subject_watch'] && $tracker->isMySubject($url))
	    {
		return $tracker->getName();
	    }
	}

	return null;
    }
}

?>