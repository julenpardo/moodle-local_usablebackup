<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * local_resourceexporter lib functions.
 *
 * @package    local_resourceexporter
 * @copyright  2016 onwards Julen Pardo & Mondragon Unibertsitatea
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Adds the created url to the course administration block.
 * Before anything, checks that we are actually in a course, and, then, that an administration block actually  exists.
 *
 * The icon used is the same as the one used by the backup; is probably the one that fits better.
 *
 * See documentation: https://docs.moodle.org/dev/Navigation_API#Navbar
 *
 * @param object $navigation The navigation object.
 * @param object $context The given context.
 */
function local_resourceexporter_extend_settings_navigation($navigation, $context) {
    global $COURSE;

    $iscourse = $context->contextlevel === CONTEXT_COURSE;

    if ($iscourse) {
        $parent = $navigation->find('courseadmin', navigation_node::TYPE_COURSE);
        $existsadminblock = $parent;

        if ($existsadminblock) {
            $pluginname = get_string('download', 'local_resourceexporter');
            $url = new moodle_url('/local/resourceexporter/create_zip.php', array('courseid' => $COURSE->id));
            $icon = new pix_icon('i/backup', '');

            $parent->add($pluginname, $url, navigation_node::TYPE_SETTING, null, null, $icon);
        }
    }
}

/**
 * Checks if the user is admin, checking if has the capability of site config.
 *
 * @param int $coursecontext The course context.
 * @return boolean If the user is admin, or not.
 */
function local_resourceexporter_is_admin($coursecontext) {
    $isadmin = has_capability('moodle/site:config', $coursecontext);

    return $isadmin;
}