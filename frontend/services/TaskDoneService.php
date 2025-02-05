<?php

namespace frontend\services;

use frontend\models\Reviews;
use frontend\models\Tasks;
use Yii;
use yii\web\BadRequestHttpException;

class TaskDoneService
{
    public function execute(array $data, int $task_id): void
    {
        $task = Tasks::findOne($task_id);
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $this->createReview($data, $task);
            $this->updateTask($data, $task);
            $this->updateCounters($task);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    private function createReview(array $data, tasks $task)
    {
        $review = new Reviews();
        $review->load($data);
        $review->task_id = $task->id;
        if ($review->validate()) {
            return $review->save();
        } else {
            throw new BadRequestHttpException($review->getErrors());
        }
    }

    private function updateTask(array $data, tasks $task)
    {
        $task->load($data);
        return $task->save();
    }

    private function updateCounters(Tasks $task)
    {
        if ($task->status == Tasks::STATUS_DONE) {
            if ($task->executor->done_tasks) {
                $task->executor->updateCounters(['done_tasks' => 1]);
            } else {
                $task->executor->done_tasks = 1;
                $task->executor->save();

            }
        } elseif ($task->status == Tasks::STATUS_FAILED) {
            if ($task->executor->failed_tasks) {
                $task->executor->updateCounters(['failed_tasks' => 1]);
            } else {
                $task->executor->failed_tasks = 1;
                $task->executor->save();
            }
        }
    }
}
