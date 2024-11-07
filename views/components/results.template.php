<?php
$total_votes = array_sum(array_column($results, 'votes'));
?>
<div>
    <p class="mb-4"><?= "There has been a total of {$total_votes}".(($total_votes === 1) ? " vote" : " votes")." so far."; ?></p>
    <?php foreach ($results as $result): ?>
        <div class="flex items-center my-1">
            <div class="w-20 flex-shrink-0 flex items-center">
                <?= "{$result['name']}\n"; ?>
            </div>
            <div class="flex-1">
                <div
                    class="flex items-center text-white bg-primary"
                    style="width:<?= ceil(($result['votes'] * 100) / $total_votes); ?>%;"
                >
                    <?= "{$result['votes']}\n"; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>