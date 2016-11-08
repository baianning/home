<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "home".
 *
 * @property integer $h_id
 * @property string $address
 * @property string $area
 * @property string $model
 * @property string $name
 * @property integer $state
 * @property integer $attention
 * @property integer $count
 * @property string $time
 * @property integer $a_id
 */
class Home extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'home';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'attention', 'count', 'a_id'], 'integer'],
            [['time'], 'safe'],
            [['a_id'], 'required'],
            [['address', 'area', 'model', 'name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'h_id' => 'H ID',
            'address' => 'Address',
            'area' => 'Area',
            'model' => 'Model',
            'name' => 'Name',
            'state' => 'State',
            'attention' => 'Attention',
            'count' => 'Count',
            'time' => 'Time',
            'a_id' => 'A ID',
        ];
    }
}
