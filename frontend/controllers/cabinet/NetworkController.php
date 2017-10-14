<?php
namespace frontend\controllers\cabinet;

use shop\services\auth\NetworkService;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class NetworkController extends Controller
{
    public $layout = 'cabinet';

    private $networkService;

    public function __construct(
        $id,
        $module,
        NetworkService $networkService,
        $config = [])
    {
        $this->networkService = $networkService;
        parent::__construct($id, $module, $config = []);
    }

    public function actions()
    {
        return [
            'attach' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');

        $id = Yii::$app->user->id;

        try {
            $this->networkService->attach($id, $network, $identity);
            Yii::$app->session->setFlash('success', 'Network is successfully attached.');
        } catch(\DomainException $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }


}