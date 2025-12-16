<?php
namespace SWC\Admin\Pages;

use SWC\Analytics\Repository;

class Analytics
{
    public function render(): void
    {
        $repo = new Repository();
        $summary = $repo->summary();
        echo '<div class="swc-card">';
        echo '<p>' . esc_html__('Privacy-friendly click analytics.', 'smart-whatsapp-chat') . '</p>';
        echo '<div class="swc-analytics-grid">';
        echo '<div><strong>' . esc_html__('Total Clicks', 'smart-whatsapp-chat') . '</strong><span>' . intval($summary['total']) . '</span></div>';
        echo '<div><strong>' . esc_html__('Top Agent', 'smart-whatsapp-chat') . '</strong><span>' . esc_html($summary['top_agent']) . '</span></div>';
        echo '<div><strong>' . esc_html__('Top Page', 'smart-whatsapp-chat') . '</strong><span>' . esc_html($summary['top_page']) . '</span></div>';
        echo '</div>';
        echo '<div class="swc-table-filter">';
        echo '<label>' . esc_html__('Start', 'smart-whatsapp-chat') . ' <input type="date" id="swc-date-start"></label>';
        echo '<label>' . esc_html__('End', 'smart-whatsapp-chat') . ' <input type="date" id="swc-date-end"></label>';
        echo '<button class="button swc-refresh-analytics">' . esc_html__('Filter', 'smart-whatsapp-chat') . '</button>';
        echo '</div>';
        echo '<table class="swc-table"><thead><tr><th>' . esc_html__('Agent', 'smart-whatsapp-chat') . '</th><th>' . esc_html__('Page', 'smart-whatsapp-chat') . '</th><th>' . esc_html__('Device', 'smart-whatsapp-chat') . '</th><th>' . esc_html__('Date', 'smart-whatsapp-chat') . '</th></tr></thead><tbody id="swc-analytics-rows">';
        foreach ($repo->latest() as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->agent ?: __('Default', 'smart-whatsapp-chat')) . '</td>';
            echo '<td>' . esc_html($row->page_title) . '</td>';
            echo '<td>' . esc_html($row->device) . '</td>';
            echo '<td>' . esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($row->created_at))) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    }
}
