<?php
/**
 * File: ScorePublisher.php
 * User: xialeistudio
 * Date: 2024/7/2
 **/

namespace app;

interface ScorePublisher
{
    public function publishScore(): int;
}