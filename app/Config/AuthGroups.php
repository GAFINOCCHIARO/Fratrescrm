<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'user';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://github.com/codeigniter4/shield/blob/develop/docs/quickstart.md#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title' => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title' => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'developer' => [
            'title' => 'Developer',
            'description' => 'Site programmers.',
        ],
        'user' => [
            'title' => 'User',
            'description' => 'General users of the site. Often customers.',
        ],
        'beta' => [
            'title' => 'Beta User',
            'description' => 'Has access to beta-level features.',
        ],
    ];
    public array $Appgroups = [
        'superadmin' => [
            'title' => 'superadmin',
            'description' => 'amministatore assoviazione',
        ],
        'admin' => [
            'title' => 'Admin',
            'description' => 'Amminiastratore dashboard',
        ],
        'user' => [
            'title' => 'User',
            'description' => 'Utenza donatore',
        ],
    ];
    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.level_up' => 'Assegnare livelli', // lang('Auth.admin_userbanned'),
        'admin.userbanned' => 'Consenso bannere utente',
        'admin.activateuser' => 'Consenso attivare doantore',
        'admin.edituser' => 'Consenso accesso dati utente',
        'admin.dashboardacces' => 'Consenso accesso dashborad ',
        'admin.change_password' => 'Può cambiare la sua password',
        'admin.editexsam' => 'consenti accesso storico esami',
        'admin.changedatauser' => 'Consenso modifica dati Utenti',
        'admin.newuserinsert' => 'Consenso inserimento nuovo donatore',
        'admin.userdelete' => 'Consenso cancellazione utente',
        'admin.managecaicode' => 'Consenso gestione codie CAI',
        'admin.findfromcai' => 'Consenso gestione esami (dottore)',
        'admin.downladreport' => 'Consenso download reoprt personale',
        'admin.uploadfile' => 'Consenso upload esami utenti',
        'admin.infosendmessage' => 'Consenso invio notifiche a donatori',
        'admin.changecompanyprofile' => 'Consenso modifica dati associazione',
        'admin.createappointments' => 'Consenso crazione agenda',
        'admin.InsertPrivacyPolicy'=>'Gestione privacy policy',
        'user.change_password' => 'Consenti cambio password',
        'user.homeaccess' => 'utenza user',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'user.*',
            // 'beta.*',
        ],
        'admin' => [
            'user.*',
        ],
        'developer' => [
            'admin.access',
            'admin.settings',
            'users.create',
            'users.edit',
            'beta.access',
        ],
        'users' => [
            'user.change_password',
            'user.homeaccess',
        ],
        'beta' => [
            'beta.access',
        ],
    ];
}
