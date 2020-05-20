<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'icon' => 'dashboard',
                        'url' => ['/'],
                        'active' => true,
                        'items' => [
                            ['label' => 'Modal Windows', 'icon' => 'tv', 'url' => ['/modal'],],
                            ['label' => 'Product tours', 'icon' => 'list-alt', 'url' => ['/product-tour'],],
                            ['label' => 'Categories', 'icon' => 'reorder', 'url' => ['/category'],],
                            ['label' => 'Product tour Admins', 'icon' => 'users', 'url' => ['/product-tour-admin'],'visible' => (Yii::$app->user->identity->level == 100)],
                            ['label' => 'Product tour Clients', 'icon' => 'television', 'url' => ['/product-tour-client'],'visible' => (Yii::$app->user->identity->level == 100)],
                            ['label' => 'Users', 'icon' => 'list-alt', 'url' => ['/user'], 'visible' => (Yii::$app->user->identity->level == 100)],
                            ['label' => 'Documentation', 'icon' => 'question-circle', 'url' => ['/documentation'],],
                        ]
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
