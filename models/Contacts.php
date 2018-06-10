<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 * @property string $created_on
 * @property string $updated_on
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['name', 'email', 'subject','body','country', 'province'], 'required'],
			[['email'], 'email'],
            [['body', 'country', 'province'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'subject' => 'Subject',
            'body' => 'Body',
			'country' => 'Country',
			'province' => 'Province',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }
}
