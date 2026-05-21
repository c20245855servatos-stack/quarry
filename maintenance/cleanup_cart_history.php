<?php
/**
 * Cart History Cleanup Script
 * 
 * This script removes cart history entries older than 90 days
 * Run this script periodically (e.g., via cron job) to keep the database clean
 * 
 * Usage: php maintenance/cleanup_cart_history.php
 */

declare(strict_types=1);

// Set the base path
define('BASE_PATH', dirname(__DIR__));

// Load the Material model
require_once BASE_PATH . '/app/models/Material.php';

try {
    $material = new Material();
    
    // Clean up cart history older than 90 days
    $deletedCount = $material->clearAllOldCartHistory(90);
    
    echo "Cart History Cleanup Complete\n";
    echo "Deleted {$deletedCount} old cart history entries\n";
    echo "Date: " . date('Y-m-d H:i:s') . "\n";
    
    // Log the cleanup
    $material->log('Cart History Cleanup', "Cleaned up {$deletedCount} old cart history entries", null, 'System');
    
} catch (Exception $e) {
    echo "Error during cleanup: " . $e->getMessage() . "\n";
    exit(1);
}