<?php

namespace biz\core\inventory\models;

use Yii;

/**
 * This is the model class for table "{{%transfer}}".
 *
 * @property integer $id
 * @property string $number
 * @property integer $branch_id
 * @property integer $branch_dest_id
 * @property string $date
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property TransferDtl[] $transferDtls
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>  
 * @since 3.0
 */
class Transfer extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 10;
    const STATUS_PARTIAL_RELEASE = 20;
    const STATUS_COMPLETE_RELEASE = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['branch_id', 'branch_dest_id', 'date', 'transferDtls'], 'required'],
            [['status'], 'default', 'value' => static::STATUS_DRAFT],
            [['branch_id', 'branch_dest_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['number'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'branch_id' => 'Branch ID',
            'branch_dest_id' => 'Branch Dest ID',
            'date' => 'Date',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransferDtls()
    {
        return $this->hasMany(TransferDtl::className(), ['transfer_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return[
            'BizTimestampBehavior',
            'BizBlameableBehavior',
            [
                'class' => 'mdm\autonumber\Behavior',
                'digit' => 6,
                'attribute' => 'number',
                'value' => 'IT' . date('y.?')
            ],
            'BizStatusConverter',
            'mdm\behaviors\ar\RelationBehavior',
        ];
    }
}