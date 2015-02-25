<?php

namespace app\commands;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use schmunk42\giiant\crud\providers\CallbackProvider;
use schmunk42\giiant\crud\providers\DateTimeProvider;
use schmunk42\giiant\crud\providers\EditorProvider;
use schmunk42\giiant\crud\providers\RangeProvider;
use schmunk42\giiant\crud\providers\RelationProvider;
use schmunk42\giiant\crud\providers\SelectProvider;

class DnaYii2DbFrontendBatchController extends DnaBatchController
{

    public $crudGenerator = 'gii/giiant-crud';

    //public $dataModelClassPath;

    /*
    public $modelNamespace = 'app\\models';
    public $crudControllerNamespace = 'app\\controllers\\crud';
    public $crudViewPath = '@app/views/crud';
    public $crudPathPrefix = 'crud/';
    */

    //public $modelBaseClass = 'app\\models';
    public $modelNamespace = 'app\\models';
    public $crudControllerNamespace = 'app\\modules\\crud\\controllers';
    public $crudViewPath = '@app/modules/crud/views';

    public function actionIndex()
    {

        // Require a config directive about what bootstrap include we should include (this script is used to activate providers for code generation)
        $alias = getenv('CODE_GENERATOR_BOOTSTRAP_INCLUDE_ALIAS');
        if (empty($alias)) {
            throw new Exception("CODE_GENERATOR_BOOTSTRAP_INCLUDE_ALIAS not set");
        }

        $crudModels = \ItemTypes::where('generate_phundament_crud');
        $qaStateModels = \DataModel::qaStateModels();

        // merge
        $cruds = array_merge($crudModels, $qaStateModels);

        // init actions
        $actions = array();

        // generate hybrid CRUDs into application
        foreach ($cruds AS $modelClass => $table) {
            $this->tableNameMap[$table] = $modelClass;
            $this->tables[] = $table;
        }

        if (false) {
            $this->tables = array( //"foo",
            );
        }

        $providers = [
            CallbackProvider::className(),
            EditorProvider::className(),
            DateTimeProvider::className(),
            //RangeProvider::className(),
            //SelectProvider::className(),
            RelationProvider::className()
        ];

        $this->generateModels();
        $this->generateCrud();
    }

}