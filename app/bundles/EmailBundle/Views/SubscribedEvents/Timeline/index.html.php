<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */



if ($item = ((isset($event['extra'])) ? $event['extra']['stat'] : false)): ?>
    <p>
        <?php if (empty($item['dateRead'])) : ?>
            <?php echo $view['translator']->trans('mautic.email.timeline.event.not.read'); ?>
        <?php else : ?>
            <?php echo $view['translator']->trans(
                'mautic.email.timeline.event.'.$event['extra']['type'],
                [
                    '%date%'     => $view['date']->toFull($item['dateRead']),
                    '%interval%' => $view['date']->formatRange($item['timeToRead']),
                    '%sent%'     => $view['date']->toFull($item['dateSent']),
                ]
            ); ?>
        <?php endif; ?>
        <?php if (!empty($item['viewedInBrowser'])) : ?>
            <?php echo $view['translator']->trans('mautic.email.timeline.event.viewed.in.browser'); ?>
        <?php endif; ?>
        <?php if (!empty($item['retryCount'])) : ?>
            <?php echo $view['translator']->transChoice(
                'mautic.email.timeline.event.retried',
                $item['retryCount'],
                ['%count%' => $item['retryCount']]
            ); ?>
        <?php endif; ?>
        <?php if (!empty($item['list_name'])) : ?>
            <?php echo $view['translator']->trans('mautic.email.timeline.event.list', ['%list%' => $item['list_name']]); ?>
        <?php endif; ?>
    </p>
    <div class="small">
    <?php
    if (isset($item['openDetails']['bounces'])):
        unset($item['openDetails']['bounces']);
    endif;

    if (!empty($item['openDetails'])):
        $counter = 1;
        foreach ($item['openDetails'] as $detail):
            if (empty($showMore) && $counter > 5):
                $showMore = true;

                echo '<div style="display:none">';
            endif;
            $counter++;
            ?>
            <hr/>
            <strong><?php echo $view['date']->toText($detail['datetime'], 'UTC'); ?></strong><br/><?php echo $detail['useragent']; ?>
        <?php endforeach; ?>
        <?php

        if (!empty($showMore)):
            echo '</div>';
            echo '<a href="javascript:void(0);" class="text-center small center-block mt-xs" onclick="Mautic.toggleTimelineMoreVisiblity(mQuery(this).prev());">';
            echo $view['translator']->trans('mautic.core.more.show');
            echo '</a>';
        endif;
        ?>
    <?php endif; ?>
    </div>
<?php endif; ?>
