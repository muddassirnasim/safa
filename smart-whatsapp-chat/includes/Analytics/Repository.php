<?php
namespace SWC\Analytics;

class Repository
{
    private string $table;

    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix . 'swc_clicks';
    }

    public function insert(array $data): void
    {
        global $wpdb;
        $wpdb->insert($this->table, [
            'agent' => $data['agent'],
            'page_id' => $data['page_id'],
            'page_title' => $data['page_title'],
            'page_url' => $data['page_url'],
            'device' => $data['device'],
            'created_at' => current_time('mysql'),
        ]);
    }

    public function latest(): array
    {
        global $wpdb;
        return $wpdb->get_results("SELECT agent, page_title, device, created_at FROM {$this->table} ORDER BY created_at DESC LIMIT 20");
    }

    public function summary(): array
    {
        global $wpdb;
        $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$this->table}");
        $top_agent = (string) $wpdb->get_var("SELECT agent FROM {$this->table} GROUP BY agent ORDER BY COUNT(*) DESC LIMIT 1");
        $top_page = (string) $wpdb->get_var("SELECT page_title FROM {$this->table} GROUP BY page_id ORDER BY COUNT(*) DESC LIMIT 1");
        return [
            'total' => $total,
            'top_agent' => $top_agent ?: __('Default', 'smart-whatsapp-chat'),
            'top_page' => $top_page ?: __('Homepage', 'smart-whatsapp-chat'),
        ];
    }

    public function filter(string $start, string $end): array
    {
        global $wpdb;
        $clauses = [];
        $params = [];
        if ($start) {
            $clauses[] = 'created_at >= %s';
            $params[] = $start . ' 00:00:00';
        }
        if ($end) {
            $clauses[] = 'created_at <= %s';
            $params[] = $end . ' 23:59:59';
        }
        $where = $clauses ? 'WHERE ' . implode(' AND ', $clauses) : '';
        if ($params) {
            $sql = $wpdb->prepare("SELECT agent, page_title, device, created_at FROM {$this->table} {$where} ORDER BY created_at DESC LIMIT 200", $params);
        } else {
            $sql = "SELECT agent, page_title, device, created_at FROM {$this->table} {$where} ORDER BY created_at DESC LIMIT 200";
        }
        return $wpdb->get_results($sql);
    }
}
