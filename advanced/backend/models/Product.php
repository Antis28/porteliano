<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\helpers\Url;


/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $title
 * @property string $section_id
 * @property string $material_id
 * @property string $style_id
 * @property string $manufacturer_id
 * @property string $img
 * @property string $description
 *
 * @property Price[] $prices
 * @property Manufacturer $manufacturer
 * @property Material $material
 * @property Section $section
 * @property Style $style
 */
class Product extends ActiveRecord
{
    public $imageFile;

    public $upload_files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'material_id', 'style_id', 'manufacturer_id','img'], 'required'],
            [['section_id'],'integer', 'min'=> 1],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['img'], 'safe'],
            [['upload_files', '$imageFile'],'safe'],
            //[['imageFile'], 'file', 'skipOnEmpty' => 'true', 'extensions' => 'png, jpg'],
            [['manufacturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturer::className(), 'targetAttribute' => ['manufacturer_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => Style::className(), 'targetAttribute' => ['style_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'title' => 'Название',
            'section_id' => 'Категория',
            'material_id' => 'Материал',
            'style_id' => 'Стиль',
            'manufacturer_id' => 'Производитель',
            'img' => 'Имя файла',
            'upload_files' => 'Дополнительные файлы',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::className(), ['id' => 'manufacturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    public function getSections(){

        $sp = Section::find()->select('id,title')->each();
        return ArrayHelper::merge(['0' => ''],ArrayHelper::map($sp,'id','title'));
    }

    public function getMaterials(){

        $sp = Material::find()->select('id,title')->each();
        return ArrayHelper::merge(['0' => ''],ArrayHelper::map($sp,'id','title'));
    }
    public function getManufacturers(){

        $sp = Manufacturer::find()->select('id,title')->each();
        return ArrayHelper::merge([0 => ''],ArrayHelper::map($sp, 'id','title'));
    }
    public function getStyles(){

        $sp = Style::find()->select('id,title')->each();
        return ArrayHelper::merge(['0' => ''],ArrayHelper::map($sp,'id','title'));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStyle()
    {
        return $this->hasOne(Style::className(), ['id' => 'style_id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    public function getFiles()
    {
        return $this->hasMany(File::className(), ['product_id' => 'id']);
    }

//    public function upload(){
//
//        if ($this->img) {
//
//            $path = Url::to('@frontend/web/img/'.$this->manufacturer->title.'/');
//            $filename = strtolower($this->img);
//            $this->imageFile->saveAS($path,$filename);
//
//        }
//    }


    public function afterFind()
    {
        parent::afterFind();
        foreach($this->getFiles()->all() as $file) {
            $this->upload_files[] = $file->getAttribute('file');
        }
        $imageFile = $this->img;
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)){


            return true;
        }
        else return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub


        foreach ($this->upload_files as $file) {
            if (isset($file)) {
                $modelFile = new File();
                $modelFile->file = $file;
                $modelFile->product_id = $this->id;
                $modelFile->save();
            }
        }

//        $this->load(Yii::$app->request->post());
//        var_dump($this->upload_files);
    }
}
