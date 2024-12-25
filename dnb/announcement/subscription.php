<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        switch ($action) {
            case 'save_subscription':
                saveSubscription($pdo, $_POST);
                break;

            case 'get_categories':
                fetchCategories($pdo);
                break;

            case 'get_subscriptions':
                fetchSubscriptions($pdo, $_POST['usn'] ?? '');
                break;

            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function saveSubscription($pdo, $data)
{
    $usn = $data['usn'] ?? '';
    $dept_id = $data['dept_id'] ?? '';
    $categories = $data['categories'] ?? []; // Expected to be an array

    if (empty($usn) || empty($dept_id) || empty($categories)) {
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        return;
    }

    $pdo->beginTransaction();
    try {
        // Delete old subscriptions
        $deleteQuery = "DELETE FROM subscription WHERE usn = :usn";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute(['usn' => $usn]);

        // Insert new subscriptions
        $insertQuery = "INSERT INTO subscription(usn, dept_id, category_id) VALUES (:usn, :dept_id, :category_id)";
        $stmt = $pdo->prepare($insertQuery);

        foreach ($categories as $category_id) {
            $stmt->execute([
                'usn' => $usn,
                'dept_id' => $dept_id,
                'category_id' => $category_id
            ]);
        }

        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function fetchCategories($pdo)
{
    try {
        $query = "SELECT * FROM announcement_type";
        $stmt = $pdo->query($query);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categories);
    } catch (Exception $e) {
        throw $e;
    }
}

function fetchSubscriptions($pdo, $usn)
{
    if (empty($usn)) {
        echo json_encode(['success' => false, 'error' => 'User ID is required']);
        return;
    }

    try {
        $query = "SELECT category_id FROM user_subscriptions WHERE usn = :usn";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['usn' => $usn]);
        $subscriptions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode(['subscriptions' => $subscriptions]);
    } catch (Exception $e) {
        throw $e;
    }
}

// Error logging configuration
ini_set('display_errors', 1);  // Display errors in the browser (for debugging purposes)
ini_set('log_errors', 1);      // Log errors
ini_set('error_log', 'php_errors.log');  // Define log file for PHP errors
?>