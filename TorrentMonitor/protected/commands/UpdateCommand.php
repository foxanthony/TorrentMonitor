<?php
class UpdateCommand extends CConsoleCommand
{
    /**
     * Perform update action. This function will be run
     * every 20 minutes by crontab or another scheduler.
     * @cron 20 * * * *
     */
    public function actionUpdate()
    {
	$this->updateSubjects();
    }

    /**
     * Perform update subjects.
     */
    public function updateSubjects()
    {
	// TODO: implement update subjects
    }
}
?>