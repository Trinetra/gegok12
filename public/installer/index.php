<?php
/**
 * Gego K12 - Visual Installation Wizard
 * 
 * A standalone PHP installer that works without Laravel
 * Handles: Requirements check, Database setup, Primary configuration
 * 
 * @version 1.1
 */

session_start();

// Define base paths
define('BASE_PATH', dirname(dirname(__DIR__)));
define('PUBLIC_PATH', dirname(__DIR__));
define('INSTALLER_PATH', __DIR__);

// Check if already installed
if (file_exists(BASE_PATH . '/storage/installed')) {
    header('Location: ../');
    exit;
}

// Get current step
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
$error = '';
$success = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once INSTALLER_PATH . '/includes/functions.php';
    
    switch ($step) {
        case 2:
            // Requirements check - just proceed
            header('Location: ?step=3');
            exit;
            break;
            
        case 3:
            // Database configuration
            $result = saveDatabaseConfig($_POST);
            if ($result['success']) {
                $_SESSION['db_configured'] = true;
                header('Location: ?step=4');
                exit;
            } else {
                $error = $result['message'];
            }
            break;
            
        case 4:
            // Admin setup
            $result = saveAdminConfig($_POST);
            if ($result['success']) {
                $_SESSION['admin_configured'] = true;
                header('Location: ?step=5');
                exit;
            } else {
                $error = $result['message'];
            }
            break;
            
        case 5:
            // Final installation
            $result = runInstallation();
            if ($result['success']) {
                $_SESSION['installation_complete'] = true;
                header('Location: ?step=6');
                exit;
            } else {
                $error = $result['message'];
            }
            break;
    }
}

// Include the view
require_once INSTALLER_PATH . '/includes/header.php';

switch ($step) {
    case 1:
        require_once INSTALLER_PATH . '/views/welcome.php';
        break;
    case 2:
        require_once INSTALLER_PATH . '/includes/functions.php';
        require_once INSTALLER_PATH . '/views/requirements.php';
        break;
    case 3:
        require_once INSTALLER_PATH . '/views/database.php';
        break;
    case 4:
        require_once INSTALLER_PATH . '/views/admin.php';
        break;
    case 5:
        require_once INSTALLER_PATH . '/views/install.php';
        break;
    case 6:
        require_once INSTALLER_PATH . '/views/complete.php';
        break;
    default:
        require_once INSTALLER_PATH . '/views/welcome.php';
}

require_once INSTALLER_PATH . '/includes/footer.php';
