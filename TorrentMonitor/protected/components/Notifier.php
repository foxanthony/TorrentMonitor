<?php
/**
 * Email notifier. Using yii-mail module.
 */
class Notifier
{
    /**
     * Notify using html-view and model.
     * @param string $viewName Html-based view name.
     * @param mixed $model Model.
     * @param string $title Email subject.
     */
    public static function modelNotify($viewName, $model, $title)
    {
	try
	{
	    $message = new YiiMailMessage;
	    $message->view = $viewName;

	    $message->setSubject($title);
	    $message->setBody(array('model' => $model, 'title' => $title), 'text/html');

	    foreach (mb_split(';|,',Yii::app()->params['notifyEmail']) as $recipient)
	    {
		$message->addTo($recipient);
	    }

	    $message->setFrom(array(Yii::app()->params['senderEmail'] => Yii::app()->name));

	    Yii::app()->mail->send($message);
	}
	catch (Exception $e)
	{
	    Yii::log('Cannot send message: ' . $e->getMessage(), 'error','Notifier');
	}
    }
}
?>