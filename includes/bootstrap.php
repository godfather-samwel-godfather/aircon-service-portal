<?php
/**
 * Load once per dashboard page — DB + session + auth + helpers.
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/repositories/TechnicianRepository.php';
require_once __DIR__ . '/repositories/ServiceCategoryRepository.php';
require_once __DIR__ . '/repositories/AirConditionerRepository.php';
require_once __DIR__ . '/repositories/BookingRepository.php';
require_once __DIR__ . '/repositories/PaymentRepository.php';
require_once __DIR__ . '/repositories/FaultReportRepository.php';
require_once __DIR__ . '/repositories/ServiceResultRepository.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/session_user.php';