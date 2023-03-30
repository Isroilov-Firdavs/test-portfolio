<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "posters".
 *
 * @property int $id
 * @property string $title
 * @property int $price
 * @property int $category
 * @property string $image
 * @property string $description
 * @property int $user_id
 * @property int $address
 * @property int $poster_id
 * @property string $date
 */
class Posters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'category', 'image', 'description', 'user_id', 'address', 'poster_id', 'date'], 'required'],
            [['price', 'category', 'user_id', 'address', 'poster_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'category' => 'Category',
            'image' => 'Image',
            'description' => 'Description',
            'user_id' => 'User ID',
            'address' => 'Address',
            'poster_id' => 'Poster ID',
            'date' => 'Date',
        ];
    }
}
