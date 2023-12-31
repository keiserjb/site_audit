<?php
/**
 * @file
 * Contains \SiteAudit\Check\Users\RolesPermissions.
 */

/**
 * Class SiteAuditCheckRolesRolesPermissions.
 */
class SiteAuditCheckRolesRolesPermissions extends SiteAuditCheckAbstract {

  /**
   * Implements \SiteAudit\Check\Abstract\getLabel().
   */
  public function getLabel() {
    return dt('Roles and Permissions');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getDescription().
   */
  public function getDescription() {
    return dt('Percentage of permissions assigned to individual roles.');
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultFail().
   */
  public function getResultFail() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultInfo().
   */
  public function getResultInfo() {
    $roles = array();
    $total = array_sum($this->registry['roles']);
    foreach ($this->registry['roles'] as $name => $count_permissions) {
      $percentage = number_format(($count_permissions / $total) * 100, 0);
      $roles[] = "$name: $count_permissions ($percentage%)";
    }
    return implode(', ', $roles);
  }

  /**
   * Implements \SiteAudit\Check\Abstract\getResultPass().
   */
  public function getResultPass() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getResultWarn().
   *
   * @TODO: do we check for admin perms in roles here?
   */
  public function getResultWarn() {}

  /**
   * Implements \SiteAudit\Check\Abstract\getAction().
   */
  public function getAction() {}

  /**
   * Implements \SiteAudit\Check\Abstract\calculateScore().
   */
  public function calculateScore() {
    $roles = config_get('user.role');

    $this->registry['roles'] = [];

    foreach ($roles as $rid => $role) {
      $permissions = isset($role['permissions']) ? count($role['permissions']) : 0;
      $this->registry['roles'][$role['name']] = $permissions;
    }

    return SiteAuditCheckAbstract::AUDIT_CHECK_SCORE_INFO;
  }


}
