<?php
Yii::setAlias('@app', dirname(__DIR__).'/..');
Yii::setAlias('@project', DNA_PROJECT_PATH);

$alias = getenv('CODE_GENERATOR_BOOTSTRAP_INCLUDE_ALIAS');
require(Yii::getAlias($alias));