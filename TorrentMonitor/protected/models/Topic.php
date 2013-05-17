<?php

/**
 * This is the model class for table "torrent_monitor_topic".
 *
 * The followings are the available columns in table 'torrent_monitor_topic':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $last_updated
 * @property string $tracker
 * @property integer $torrent_id
 *
 * The followings are the available model relations:
 * @property TorrentMonitorTorrent $torrent
 */
class Topic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Topic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'torrent_monitor_topic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, title', 'required'),
			array('torrent_id', 'numerical', 'integerOnly'=>true),
			array('url, title, tracker', 'length', 'max'=>255),
			array('last_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, title, last_updated, tracker, torrent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'torrent' => array(self::BELONGS_TO, 'TorrentMonitorTorrent', 'torrent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('models_Topic','ID'),
			'url' => Yii::t('models_Topic','URL'),
			'title' => Yii::t('models_Topic','Title'),
			'last_updated' => Yii::t('models_Topic','Last Updated'),
			'tracker' => Yii::t('models_Topic','Tracker'),
			'torrent_id' => Yii::t('models_Topic','Torrent'),
		);
	}

	/**
	 * Render tracker icon.
	 * @return string String contains link to image.
	 */
	public function renderTrackerIcon()
	{
	    $trackerIconFilename = $this->getTrackerIconFilename();

	    if (!isset($trackerIconFilename))
	    {
		return '<i class="icon-question-sign"></i>';
	    }
	    else
	    {
		return CHtml::image('/images/' . $this->getTrackerIconFilename(), $this->tracker, array('style'=>'width: 16px; height: 16px;'));
	    }
	}

	/**
	 * Retrieves tracker icon filename
	 * @return string Filename or null if tracker is not found.
	 */
	public function getTrackerIconFilename()
	{
	    // get topic tracker
	    $tracker = Yii::app()->trackerManager->getTopicTrackerByName($this->tracker);

	    // is it null?
	    if (!isset($tracker))
            {
	        return null;
	    }

	    return $tracker->getIconFilename();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('last_updated',$this->last_updated,true);
		$criteria->compare('tracker',$this->tracker,true);
		$criteria->compare('torrent_id',$this->torrent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}