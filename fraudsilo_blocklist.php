<?php
/**
 * FraudSilo Private Blocklist Configuration
 * 
 * Add known fraudulent names, email addresses, email domains, and IP addresses here.
 * This file is loaded at runtime by the main FraudSilo module.
 * 
 * IMPORTANT: Keep this file outside of public web directories for security.
 */

return [
    // Exact email addresses to block (case-insensitive)
    'blocked_emails' => [
        // 'scammer@example.com',
        // 'fraudster@badomain.com',
    ],

    // Email domains to block (without @, case-insensitive)
    'blocked_email_domains' => [
        // 'spamdomain.com',
        // 'fakeemail.net',
    ],

    // Names to block (case-insensitive, matches if name contains this string)
    'blocked_names' => [
        // 'Test User',
        // 'John Doe',
    ],

    // Exact name matches only (case-insensitive)
    'blocked_names_exact' => [
        // 'Asdf Asdf',
    ],

    // IP addresses to block
    'blocked_ips' => [
        // '192.168.1.1',
        // '10.0.0.0/8', // CIDR notation supported
    ],

    // IP ranges to block (start and end)
    'blocked_ip_ranges' => [
        // ['start' => '192.168.1.1', 'end' => '192.168.1.255'],
    ],

    // Phone numbers to block (normalized, digits only)
    'blocked_phones' => [
        // '5551234567',
    ],

    // Countries to block (ISO 2-letter codes)
    'blocked_countries' => [
        // 'XX',
    ],

    // Regex patterns for emails (advanced users)
    'blocked_email_patterns' => [
        // '/^test[0-9]+@/',  // Blocks test1@, test123@, etc.
        // '/\+.*@gmail\.com$/',  // Blocks Gmail plus addressing
    ],

    // Regex patterns for names (advanced users)
    'blocked_name_patterns' => [
        // '/^[a-z]{1,2}\s+[a-z]{1,2}$/i',  // Single/double letter names like "A B"
    ],
];
