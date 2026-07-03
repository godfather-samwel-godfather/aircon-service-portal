<?php
/**
 * Public bootstrap - for public-facing pages (home, contact, services, etc.)
 * Does NOT require authentication
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
require_once __DIR__ . '/repositories/ContactMessageRepository.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// NOTE: Does NOT require auth.php or session_user.php - this is for public pages
