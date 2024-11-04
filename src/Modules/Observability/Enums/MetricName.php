<?php

namespace Ninja\DeviceTracker\Modules\Observability\Enums;

enum MetricName: string
{
    case AuthSuccessCount = 'auth_success_count';
    case AuthFailureCount = 'auth_failure_count';
    case AuthSuccessRate = 'auth_success_rate';
    case AuthFailureRate = 'auth_failure_rate';
    case Auth2FASuccessCount = 'auth_2fa_success_count';
    case Auth2FAFailureCount = 'auth_2fa_failure_count';
    case Auth2FASuccessRate = 'auth_2fa_success_rate';
    case Auth2FAFailureRate = 'auth_2fa_failure_rate';
    case AuthUniqueUsers = 'auth_unique_users';

    case SessionCount = 'session_count';
    case SessionLockedCount = 'session_locked_count';
    case SessionBlockedCount = 'session_blocked_count';
    case SessionInactiveCount = 'session_inactive_count';
    case SessionDuration = 'session_duration';

    case DeviceVerificationTime = 'device_verification_time';
    case DeviceRiskScore = 'device_risk_score';
    case DeviceUniqueCount = 'device_unique_count';
    case DeviceFingerprintChanges = 'device_fingerprint_changes';
    case DeviceOsDistribution = 'device_os_distribution';
    case DeviceBrowserDistribution = 'device_browser_distribution';

    // Métricas de Ubicación
    case LocationUniqueCount = 'location_unique_count';
    case LocationChangeVelocity = 'location_change_velocity';
    case LocationCountryDistribution = 'location_country_distribution';
    case LocationSuspiciousChanges = 'location_suspicious_changes';

    // Métricas de Eventos
    case EventCount = 'event_count';
    case EventRate = 'event_rate';
    case EventErrorRate = 'event_error_rate';
    case EventLatency = 'event_latency';
    case EventSize = 'event_size';
    case EventPatternAnomaly = 'event_pattern_anomaly';

    // Métricas de Seguridad
    case SecurityBlockCount = 'security_block_count';
    case SecurityHijackCount = 'security_hijack_count';
    case SecuritySuspiciousActivity = 'security_suspicious_activity';
    case SecurityRiskDistribution = 'security_risk_distribution';


    // Métricas de Comportamiento
    case BehaviorPageTime = 'behavior_page_time';
    case BehaviorNavigationDepth = 'behavior_navigation_depth';
    case BehaviorInteractionRate = 'behavior_interaction_rate';
    case BehaviorSessionFrequency = 'behavior_session_frequency';
    case BehaviorTimeOfDay = 'behavior_time_of_day';
}