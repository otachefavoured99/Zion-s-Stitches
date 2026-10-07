<?php

function portfolio_categories(): array
{
    return [
        'bridal' => 'Bridal Wear',
        'mens' => "Men's Fashion",
        'traditional' => 'Traditional Wear',
        'other' => 'Other',
    ];
}

function ensure_portfolio_table(mysqli $conn): void
{
    $sql = "CREATE TABLE IF NOT EXISTS portfolio_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(120) NOT NULL,
        category VARCHAR(50) NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_portfolio_items_category (category)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if (!$conn->query($sql)) {
        throw new RuntimeException('Unable to create the portfolio table: ' . $conn->error);
    }
}
