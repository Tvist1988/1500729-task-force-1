<?php

use taskforce\app\StarsWidget;
use taskforce\helpers\PluralHelper;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $count = 0;
$stars = round($model->calculateStars($model->id),2); ?>
<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="user.html"><img src="/img/man-glasses.jpg" width="65" height="65"></a>
            <span><?= PluralHelper::Plural(['заданий', 'задание', 'задание', 'задания', 'заданий', 'задания'],
                    count($model->executeTasks)) ?></span>
            <?php foreach ($model->executeTasks as $task) {
                $count = $count + count ($task->reviews);
            } ?>
            <span><?= PluralHelper::Plural(['отзывов', 'отзыв', 'отзыв', 'отзыва', 'отзывов', 'отзыва'],
                    $count) ?> </span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name"><?= Html::a($model->name, ['users/view', 'id' => $model->id], ['class' => 'link-regular']) ?></p>
            <?= StarsWidget::widget(['stars' => $stars]) ?>
            <b><?= $stars ?></b>
            <p class="user__search-content">
                <?= Html::encode($model->information)?>
            </p>
        </div>
        <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->format($model->dt_last_activity, 'relativeTime')?></span>
    </div>
    <div class="link-specialization user__search-link--bottom">
        <?php foreach ($model->executorCategories as $category): ?>
            <a href="browse.html" class="link-regular"><?= $category->category->title ?></a>
        <?php endforeach; ?>
    </div>
</div>
