<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use \yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'First';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a(
                'Get Started Today',
                ['site/singup'],
                ['class' => 'btn btn-lg btn-success']
            );
        }
        ?>
        <h1>First <i class="fa fa-plug"></i></h1>
        <p class="lead">
            Use this Yii 2 template to start projects.
        </p><br>
        <?php echo FacebookPlugin::widget(
            ['type' => FacebookPlugin::LIKE, 'settings' => []]
        ); ?>
    </div>

    <?php
    // FIXME: collapse widget
    /*
    echo Collapse::widget([
        'item' => [
            [
                'label' => 'Top Features',
                'content' => FacebookPlugin::widget([
                    'type' => FacebookPlugin::SHARE,
                    'settings' => ['href'  => 'www.first.com', 'width' => '350']
                ])
            ],
            [
                'label' => 'Top Resources',
                'content' => FacebookPlugin::widget([
                    'type' => FacebookPlugin::SHARE,
                    'settings' => ['href' => 'www.first.com', 'width' => '350']
                ])
            ]
        ]
    ]); */

    Modal::begin([
        'header' => '<h2>Latest Comments </h2>',
        'toggleButton' => ['label' => 'comments']
    ]);
    echo FacebookPlugin::widget([
        'type' => FacebookPlugin::COMMENT,
        'settings' => ['href' => 'www.first.com', 'width' => '350']
    ]);
    Modal::end();
    ?>
    <br><br>
    <?php
    echo Alert::widget([
        'options' => [
            'class' => 'alert-info'
        ],
        'body' => 'Launch your project like a rocket...'
    ]);
    ?>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Free</h2>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        echo Yii::$app->user->identity->username . 'is doing coll stuff.';
                    }
                    ?>
                    Starting with this free, open source Yii 2 template and it
                    will save yoou a lot of time. You can deliver projects to the
                    customer quickly, with a lot of boilerplate already taken care
                    of for you, so you can concentrate on the complicated stuff.
                </p>
                <p>
                    <a href="www.yiiframework.com/doc/" class="btn btn-default">
                        Yii Documentation &raquo;
                    </a>
                </p>
                <?php
                echo FacebookPlugin::widget([
                    'type' => FacebookPlugin::LIKE,
                    'settings' => []
                ]);
                ?>
            </div>
            <div class="col-lg-4">
                <h2>Advantages</h2>
                <p>
                    Ease of use is a huge advantage. We've simplifiled RBAC and
                    given you Free/Paid user type out of the box. The Social
                    plugins are so quick and easy to install, you will love it!
                </p>
                <p>
                    <a href="www.yiiframework.com/forum/" class="btn btn-default">
                        Yii forum &raquo;
                    </a>
                </p>
                <?php
                echo FacebookPlugin::widget([
                    'type' => FacebookPlugin::COMMENT,
                    'settings' => ['href' => 'www.first.com', 'width' => '350']
                ]);
                ?>
            </div>
            <div class="col-lg-4">
                <h2>Code Quick, Code Right!</h2>
                <p>
                    Leverage the power of the awesome Yii 2 framework with this
                    enhanced template. Based Yii 2's advanced template, you get
                    a full frontend and backend implementation tht features rich
                    UI for backend management.
                </p>
                <p>
                    <a href="www.yiiframework.com/extensions/" class="btn btn-default">
                        Yii Extensions &raquo;
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
