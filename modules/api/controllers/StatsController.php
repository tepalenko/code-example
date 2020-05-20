<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\TutorialStats;

class StatsController extends ActiveController
{
    public $modelClass = 'app\models\TutorialStats';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        return $behaviors;
    }
    
    protected function verbs()
    {
        $verbs = parent::verbs();
        return $verbs;
    }

    /**
     * Api call for get show welcome message flag
     *
     * @param string $unique_user_id - user id generated on FE
     * @return void
     */
    public function actionShowWelcome($unique_user_id)
    {
        $stats_object =TutorialStats::find()->where(['unique_user_id' => $unique_user_id, 'show_welcome_message' => 1])->all();
        $response = [
            'show_message' => empty($stats_object)
        ];
        
        return $response;
    }

    /**
     * Api call for get hotstpot hints
     *
     * @param string $unique_user_id - user id generated on FE
     * @return void
     */
    public function actionShowHint($unique_user_id)
    {
        $stats_object =TutorialStats::find()->where(['unique_user_id' => $unique_user_id, 'show_hostpot' => 1])->orderBy('step', 'DESC')->limit(1)->all();
        
        $step = (!empty($stats_object)) ? $stats_object[0]->step : 0;
        
        $response = [
            'previous_step' => $step
        ];
        return $response;
    }
}
