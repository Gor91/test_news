<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * BaseModel model
 *
 * @property integer $created
 * @property integer $updated
 */
class BaseModel extends ActiveRecord
{
    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created = time();
        }

        $this->updated = time();
        return parent::beforeSave($insert);
    }
}