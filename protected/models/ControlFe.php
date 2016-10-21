<?php

/**
 * This is the model class for table "control_fe".
 *
 * The followings are the available columns in table 'control_fe':
 * @property string $id_registro
 * @property integer $id_usuario
 * @property string $sc_cadena
 * @property string $access_lista
 * @property string $access_masivo
 * @property string $access_descarga
 * @property double $porcentaje_lista
 * @property string $access_rsimple_personalizado
 * @property integer $access_multas
 * @property integer $access_lista_5_3
 * @property integer $access_lista_2
 * @property integer $access_lista_1
 * @property integer $spare_7
 * @property integer $spare_8
 * @property integer $spare_9
 * @property integer $spare_10
 * @property integer $spare_11
 * @property integer $spare_12
 * @property integer $spare_13
 * @property integer $spare_14
 * @property integer $spare_15
 * @property integer $spare_16
 * @property integer $spare_17
 * @property integer $spare_18
 * @property integer $spare_19
 * @property integer $spare_20
 * @property integer $spare_21
 * @property integer $spare_22
 * @property integer $spare_23
 * @property integer $spare_24
 * @property integer $spare_25
 * @property integer $spare_26
 * @property integer $spare_27
 * @property integer $spare_28
 * @property integer $spare_29
 * @property integer $spare_30
 * @property integer $spare_31
 * @property integer $spare_32
 * @property integer $spare_33
 * @property integer $spare_34
 * @property integer $spare_35
 * @property integer $spare_36
 * @property integer $spare_37
 * @property integer $spare_38
 * @property integer $spare_39
 * @property integer $spare_40
 * @property integer $spare_41
 * @property integer $spare_42
 * @property integer $spare_43
 * @property integer $spare_44
 * @property integer $spare_45
 * @property integer $spare_46
 * @property integer $spare_47
 * @property integer $spare_48
 * @property integer $spare_49
 * @property integer $spare_50
 * @property integer $spare_51
 * @property integer $spare_52
 * @property integer $spare_53
 * @property integer $spare_54
 * @property integer $spare_55
 * @property integer $spare_56
 * @property integer $spare_57
 * @property integer $spare_58
 * @property integer $spare_59
 * @property integer $spare_61
 * @property integer $spare_62
 * @property integer $spare_63
 * @property integer $spare_64
 * @property integer $spare_65
 * @property integer $spare_66
 * @property integer $spare_67
 * @property integer $spare_68
 * @property integer $spare_69
 * @property integer $spare_70
 * @property integer $spare_71
 * @property integer $spare_72
 * @property integer $spare_73
 * @property integer $spare_74
 * @property integer $spare_75
 * @property integer $spare_76
 * @property integer $spare_77
 * @property integer $spare_78
 * @property integer $spare_79
 * @property integer $spare_80
 * @property integer $spare_81
 * @property integer $spare_82
 * @property integer $spare_83
 * @property integer $spare_84
 * @property integer $spare_85
 * @property integer $spare_86
 * @property integer $spare_87
 * @property integer $spare_88
 * @property integer $spare_89
 * @property integer $spare_90
 * @property integer $spare_91
 * @property integer $spare_92
 * @property integer $spare_93
 * @property integer $spare_94
 * @property integer $spare_95
 * @property integer $spare_96
 * @property integer $spare_97
 * @property integer $spare_98
 */
class ControlFe extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'control_fe';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_usuario, sc_cadena, access_lista, access_masivo, access_descarga', 'required'),
            array('id_usuario, access_multas, access_lista_5_3, access_lista_2, access_lista_1, spare_7, spare_8, spare_9, spare_10, spare_11, spare_12, spare_13, spare_14, spare_15, spare_16, spare_17, spare_18, spare_19, spare_20, spare_21, spare_22, spare_23, spare_24, spare_25, spare_26, spare_27, spare_28, spare_29, spare_30, spare_31, spare_32, spare_33, spare_34, spare_35, spare_36, spare_37, spare_38, spare_39, spare_40, spare_41, spare_42, spare_43, spare_44, spare_45, spare_46, spare_47, spare_48, spare_49, spare_50, spare_51, spare_52, spare_53, spare_54, spare_55, spare_56, spare_57, spare_58, spare_59, spare_61, spare_62, spare_63, spare_64, spare_65, spare_66, spare_67, spare_68, spare_69, spare_70, spare_71, spare_72, spare_73, spare_74, spare_75, spare_76, spare_77, spare_78, spare_79, spare_80, spare_81, spare_82, spare_83, spare_84, spare_85, spare_86, spare_87, spare_88, spare_89, spare_90, spare_91, spare_92, spare_93, spare_94, spare_95, spare_96, spare_97, spare_98', 'numerical', 'integerOnly' => true),
            array('porcentaje_lista', 'numerical'),
            array('access_lista, access_masivo, access_descarga, access_rsimple_personalizado', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_registro, id_usuario, sc_cadena, access_lista, access_masivo, access_descarga, porcentaje_lista, access_rsimple_personalizado, access_multas, access_lista_5_3, access_lista_2, access_lista_1, spare_7, spare_8, spare_9, spare_10, spare_11, spare_12, spare_13, spare_14, spare_15, spare_16, spare_17, spare_18, spare_19, spare_20, spare_21, spare_22, spare_23, spare_24, spare_25, spare_26, spare_27, spare_28, spare_29, spare_30, spare_31, spare_32, spare_33, spare_34, spare_35, spare_36, spare_37, spare_38, spare_39, spare_40, spare_41, spare_42, spare_43, spare_44, spare_45, spare_46, spare_47, spare_48, spare_49, spare_50, spare_51, spare_52, spare_53, spare_54, spare_55, spare_56, spare_57, spare_58, spare_59, spare_61, spare_62, spare_63, spare_64, spare_65, spare_66, spare_67, spare_68, spare_69, spare_70, spare_71, spare_72, spare_73, spare_74, spare_75, spare_76, spare_77, spare_78, spare_79, spare_80, spare_81, spare_82, spare_83, spare_84, spare_85, spare_86, spare_87, spare_88, spare_89, spare_90, spare_91, spare_92, spare_93, spare_94, spare_95, spare_96, spare_97, spare_98', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_registro' => 'Id Registro',
            'id_usuario' => 'Id Usuario',
            'sc_cadena' => 'Sc Cadena',
            'access_lista' => 'Access Lista',
            'access_masivo' => 'Access Masivo',
            'access_descarga' => 'Access Descarga',
            'porcentaje_lista' => 'Porcentaje Lista',
            'access_rsimple_personalizado' => 'Access Rsimple Personalizado',
            'access_multas' => 'Access Multas',
            'access_lista_5_3' => 'Access Lista 5 3',
            'access_lista_2' => 'Access Lista 2',
            'access_lista_1' => 'Access Lista 1',
            'spare_7' => 'Spare 7',
            'spare_8' => 'Spare 8',
            'spare_9' => 'Spare 9',
            'spare_10' => 'Spare 10',
            'spare_11' => 'Spare 11',
            'spare_12' => 'Spare 12',
            'spare_13' => 'Spare 13',
            'spare_14' => 'Spare 14',
            'spare_15' => 'Spare 15',
            'spare_16' => 'Spare 16',
            'spare_17' => 'Spare 17',
            'spare_18' => 'Spare 18',
            'spare_19' => 'Spare 19',
            'spare_20' => 'Spare 20',
            'spare_21' => 'Spare 21',
            'spare_22' => 'Spare 22',
            'spare_23' => 'Spare 23',
            'spare_24' => 'Spare 24',
            'spare_25' => 'Spare 25',
            'spare_26' => 'Spare 26',
            'spare_27' => 'Spare 27',
            'spare_28' => 'Spare 28',
            'spare_29' => 'Spare 29',
            'spare_30' => 'Spare 30',
            'spare_31' => 'Spare 31',
            'spare_32' => 'Spare 32',
            'spare_33' => 'Spare 33',
            'spare_34' => 'Spare 34',
            'spare_35' => 'Spare 35',
            'spare_36' => 'Spare 36',
            'spare_37' => 'Spare 37',
            'spare_38' => 'Spare 38',
            'spare_39' => 'Spare 39',
            'spare_40' => 'Spare 40',
            'spare_41' => 'Spare 41',
            'spare_42' => 'Spare 42',
            'spare_43' => 'Spare 43',
            'spare_44' => 'Spare 44',
            'spare_45' => 'Spare 45',
            'spare_46' => 'Spare 46',
            'spare_47' => 'Spare 47',
            'spare_48' => 'Spare 48',
            'spare_49' => 'Spare 49',
            'spare_50' => 'Spare 50',
            'spare_51' => 'Spare 51',
            'spare_52' => 'Spare 52',
            'spare_53' => 'Spare 53',
            'spare_54' => 'Spare 54',
            'spare_55' => 'Spare 55',
            'spare_56' => 'Spare 56',
            'spare_57' => 'Spare 57',
            'spare_58' => 'Spare 58',
            'spare_59' => 'Spare 59',
            'spare_61' => 'Spare 61',
            'spare_62' => 'Spare 62',
            'spare_63' => 'Spare 63',
            'spare_64' => 'Spare 64',
            'spare_65' => 'Spare 65',
            'spare_66' => 'Spare 66',
            'spare_67' => 'Spare 67',
            'spare_68' => 'Spare 68',
            'spare_69' => 'Spare 69',
            'spare_70' => 'Spare 70',
            'spare_71' => 'Spare 71',
            'spare_72' => 'Spare 72',
            'spare_73' => 'Spare 73',
            'spare_74' => 'Spare 74',
            'spare_75' => 'Spare 75',
            'spare_76' => 'Spare 76',
            'spare_77' => 'Spare 77',
            'spare_78' => 'Spare 78',
            'spare_79' => 'Spare 79',
            'spare_80' => 'Spare 80',
            'spare_81' => 'Spare 81',
            'spare_82' => 'Spare 82',
            'spare_83' => 'Spare 83',
            'spare_84' => 'Spare 84',
            'spare_85' => 'Spare 85',
            'spare_86' => 'Spare 86',
            'spare_87' => 'Spare 87',
            'spare_88' => 'Spare 88',
            'spare_89' => 'Spare 89',
            'spare_90' => 'Spare 90',
            'spare_91' => 'Spare 91',
            'spare_92' => 'Spare 92',
            'spare_93' => 'Spare 93',
            'spare_94' => 'Spare 94',
            'spare_95' => 'Spare 95',
            'spare_96' => 'Spare 96',
            'spare_97' => 'Spare 97',
            'spare_98' => 'Spare 98',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_registro', $this->id_registro, true);
        $criteria->compare('id_usuario', $this->id_usuario);
        $criteria->compare('sc_cadena', $this->sc_cadena, true);
        $criteria->compare('access_lista', $this->access_lista, true);
        $criteria->compare('access_masivo', $this->access_masivo, true);
        $criteria->compare('access_descarga', $this->access_descarga, true);
        $criteria->compare('porcentaje_lista', $this->porcentaje_lista);
        $criteria->compare('access_rsimple_personalizado', $this->access_rsimple_personalizado, true);
        $criteria->compare('access_multas', $this->access_multas);
        $criteria->compare('access_lista_5_3', $this->access_lista_5_3);
        $criteria->compare('access_lista_2', $this->access_lista_2);
        $criteria->compare('access_lista_1', $this->access_lista_1);
        $criteria->compare('spare_7', $this->spare_7);
        $criteria->compare('spare_8', $this->spare_8);
        $criteria->compare('spare_9', $this->spare_9);
        $criteria->compare('spare_10', $this->spare_10);
        $criteria->compare('spare_11', $this->spare_11);
        $criteria->compare('spare_12', $this->spare_12);
        $criteria->compare('spare_13', $this->spare_13);
        $criteria->compare('spare_14', $this->spare_14);
        $criteria->compare('spare_15', $this->spare_15);
        $criteria->compare('spare_16', $this->spare_16);
        $criteria->compare('spare_17', $this->spare_17);
        $criteria->compare('spare_18', $this->spare_18);
        $criteria->compare('spare_19', $this->spare_19);
        $criteria->compare('spare_20', $this->spare_20);
        $criteria->compare('spare_21', $this->spare_21);
        $criteria->compare('spare_22', $this->spare_22);
        $criteria->compare('spare_23', $this->spare_23);
        $criteria->compare('spare_24', $this->spare_24);
        $criteria->compare('spare_25', $this->spare_25);
        $criteria->compare('spare_26', $this->spare_26);
        $criteria->compare('spare_27', $this->spare_27);
        $criteria->compare('spare_28', $this->spare_28);
        $criteria->compare('spare_29', $this->spare_29);
        $criteria->compare('spare_30', $this->spare_30);
        $criteria->compare('spare_31', $this->spare_31);
        $criteria->compare('spare_32', $this->spare_32);
        $criteria->compare('spare_33', $this->spare_33);
        $criteria->compare('spare_34', $this->spare_34);
        $criteria->compare('spare_35', $this->spare_35);
        $criteria->compare('spare_36', $this->spare_36);
        $criteria->compare('spare_37', $this->spare_37);
        $criteria->compare('spare_38', $this->spare_38);
        $criteria->compare('spare_39', $this->spare_39);
        $criteria->compare('spare_40', $this->spare_40);
        $criteria->compare('spare_41', $this->spare_41);
        $criteria->compare('spare_42', $this->spare_42);
        $criteria->compare('spare_43', $this->spare_43);
        $criteria->compare('spare_44', $this->spare_44);
        $criteria->compare('spare_45', $this->spare_45);
        $criteria->compare('spare_46', $this->spare_46);
        $criteria->compare('spare_47', $this->spare_47);
        $criteria->compare('spare_48', $this->spare_48);
        $criteria->compare('spare_49', $this->spare_49);
        $criteria->compare('spare_50', $this->spare_50);
        $criteria->compare('spare_51', $this->spare_51);
        $criteria->compare('spare_52', $this->spare_52);
        $criteria->compare('spare_53', $this->spare_53);
        $criteria->compare('spare_54', $this->spare_54);
        $criteria->compare('spare_55', $this->spare_55);
        $criteria->compare('spare_56', $this->spare_56);
        $criteria->compare('spare_57', $this->spare_57);
        $criteria->compare('spare_58', $this->spare_58);
        $criteria->compare('spare_59', $this->spare_59);
        $criteria->compare('spare_61', $this->spare_61);
        $criteria->compare('spare_62', $this->spare_62);
        $criteria->compare('spare_63', $this->spare_63);
        $criteria->compare('spare_64', $this->spare_64);
        $criteria->compare('spare_65', $this->spare_65);
        $criteria->compare('spare_66', $this->spare_66);
        $criteria->compare('spare_67', $this->spare_67);
        $criteria->compare('spare_68', $this->spare_68);
        $criteria->compare('spare_69', $this->spare_69);
        $criteria->compare('spare_70', $this->spare_70);
        $criteria->compare('spare_71', $this->spare_71);
        $criteria->compare('spare_72', $this->spare_72);
        $criteria->compare('spare_73', $this->spare_73);
        $criteria->compare('spare_74', $this->spare_74);
        $criteria->compare('spare_75', $this->spare_75);
        $criteria->compare('spare_76', $this->spare_76);
        $criteria->compare('spare_77', $this->spare_77);
        $criteria->compare('spare_78', $this->spare_78);
        $criteria->compare('spare_79', $this->spare_79);
        $criteria->compare('spare_80', $this->spare_80);
        $criteria->compare('spare_81', $this->spare_81);
        $criteria->compare('spare_82', $this->spare_82);
        $criteria->compare('spare_83', $this->spare_83);
        $criteria->compare('spare_84', $this->spare_84);
        $criteria->compare('spare_85', $this->spare_85);
        $criteria->compare('spare_86', $this->spare_86);
        $criteria->compare('spare_87', $this->spare_87);
        $criteria->compare('spare_88', $this->spare_88);
        $criteria->compare('spare_89', $this->spare_89);
        $criteria->compare('spare_90', $this->spare_90);
        $criteria->compare('spare_91', $this->spare_91);
        $criteria->compare('spare_92', $this->spare_92);
        $criteria->compare('spare_93', $this->spare_93);
        $criteria->compare('spare_94', $this->spare_94);
        $criteria->compare('spare_95', $this->spare_95);
        $criteria->compare('spare_96', $this->spare_96);
        $criteria->compare('spare_97', $this->spare_97);
        $criteria->compare('spare_98', $this->spare_98);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getAccesos($usuario) {
        $controlFe = ControlFe::model()->findAllByAttributes(array('id_usuario' => $usuario), array('select' => 'sc_cadena'));

        return $controlFe;
    }

    public function getAccesoBTL($usuario) {
        $controlFe = ControlFe::model()->findByAttributes(array('id_usuario' => $usuario,'access_lista'=>1), array('select' => 'access_lista'));
        if ($controlFe !== null) {
            return $controlFe->access_lista;
            if ($controlFe->access_lista == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db_sms;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ControlFe the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
