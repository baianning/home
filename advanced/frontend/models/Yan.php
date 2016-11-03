<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yan".
 *
 * @property integer $id
 * @property string $title
 * @property string $connet
 */
class Yan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['connet'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'connet' => 'Connet',
        ];
    }
}
