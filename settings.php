<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     aiprovider_schooleesopenrouter
 * @copyright   2024 Marcus Green
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Moodle 5+ uses per-instance provider configuration via hooks and the AI Providers UI.
// Keep this file as a no-op to avoid duplicate/legacy configuration pages.
global $CFG;
if (!empty($CFG->version) && $CFG->version >= 2025041400) {
    return;
}

if ($hassiteconfig) {
    // Provider specific settings heading.
    $settings = new \core_ai\admin\admin_settingspage_provider(
        'aiprovider_schooleesopenrouter',
        new lang_string('pluginname', 'aiprovider_schooleesopenrouter'),
        'moodle/site:config',
        true,
    );

    $settings->add(new admin_setting_heading(
        'aiprovider_schooleesopenrouter/general',
        new lang_string('settings', 'core'),
        '',
    ));

    // Setting to store OpenRouter API key.
    $settings->add(new admin_setting_configpasswordunmask(
        'aiprovider_schooleesopenrouter/apikey',
        new lang_string('apikey', 'aiprovider_schooleesopenrouter'),
        new lang_string('apikey_desc', 'aiprovider_schooleesopenrouter'),
        '',
    ));

    // Setting to store OpenRouter organization ID.
    $settings->add(new admin_setting_configtext(
        'aiprovider_schooleesopenrouter/orgid',
        new lang_string('orgid', 'aiprovider_schooleesopenrouter'),
        new lang_string('orgid_desc', 'aiprovider_schooleesopenrouter'),
        '',
        PARAM_TEXT,
    ));

    // Setting to enable/disable global rate limiting.
    $settings->add(new admin_setting_configcheckbox(
        'aiprovider_schooleesopenrouter/enableglobalratelimit',
        new lang_string('enableglobalratelimit', 'aiprovider_schooleesopenrouter'),
        new lang_string('enableglobalratelimit_desc', 'aiprovider_schooleesopenrouter'),
        0,
    ));

    // Setting to set how many requests per hour are allowed for the global rate limit.
    // Should only be enabled when global rate limiting is enabled.
    $settings->add(new admin_setting_configtext(
        'aiprovider_schooleesopenrouter/globalratelimit',
        new lang_string('globalratelimit', 'aiprovider_schooleesopenrouter'),
        new lang_string('globalratelimit_desc', 'aiprovider_schooleesopenrouter'),
        100,
        PARAM_INT,
    ));
    $settings->hide_if(
        'aiprovider_schooleesopenrouter/globalratelimit',
        'aiprovider_schooleesopenrouter/enableglobalratelimit',
        'eq',
        0
    );

    // Setting to enable/disable user rate limiting.
    $settings->add(new admin_setting_configcheckbox(
        'aiprovider_schooleesopenrouter/enableuserratelimit',
        new lang_string('enableuserratelimit', 'aiprovider_schooleesopenrouter'),
        new lang_string('enableuserratelimit_desc', 'aiprovider_schooleesopenrouter'),
        0,
    ));

    // Setting to set how many requests per hour are allowed for the user rate limit.
    // Should only be enabled when user rate limiting is enabled.
    $settings->add(new admin_setting_configtext(
        'aiprovider_schooleesopenrouter/userratelimit',
        new lang_string('userratelimit', 'aiprovider_schooleesopenrouter'),
        new lang_string('userratelimit_desc', 'aiprovider_schooleesopenrouter'),
        10,
        PARAM_INT,
    ));
    $settings->hide_if(
        'aiprovider_schooleesopenrouter/userratelimit',
        'aiprovider_schooleesopenrouter/enableuserratelimit',
        'eq',
        0
    );

    $url = new moodle_url('../ai/provider/schooleesopenrouter/test_connection.php');
    $link = html_writer::link($url, get_string('testaiservices', 'aiprovider_schooleesopenrouter'));
    $settings->add(new admin_setting_heading(
        'testaiconfiguration',
        new lang_string('testaiconfiguration', 'aiprovider_schooleesopenrouter'),
        new lang_string('testoutgoingmaildetail', 'admin', $link),
    ));
}
