<?php

namespace frontend\models;

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
 *
 * @property Country $address0
 * @property Category $category0
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
            [['title', 'price', 'category', 'description',  'address'], 'required'],
            // [['image'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg' ,'webp'],
            [['image'], 'image',  'extensions' => 'png, jpg, jpeg, webp'],
            [['price', 'category', 'user_id', 'address', 'poster_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'image'], 'string', 'max' => 255],
            [['date'], 'string', 'max' => 60],
            [['address'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['address' => 'id']],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'id']],
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

    /**
     * Gets query for [[Address0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddres()
    {
        return $this->hasOne(Country::className(), ['id' => 'address']);
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
