<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Http\Controllers\Permission\PermissionController as PermissionController;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('createserver', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "cancreateservers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('deleteserver', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "candeleteservers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('modifyserver', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canmodifyservers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('overridemanager', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canoverridemanager") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('managekey', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canmanagedtquerykey") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('createuser', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "cancreateusers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('deleteuser', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "candeleteusers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('modifyuser', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canmodifyusers") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('installplugin', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "caninstallplugins") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('seeallchat', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canseeallchat") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('deletechat', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "candeletechat") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('seeallmessages', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canseeallmessages") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('deletemessage', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "candeletemessages") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('verifyuser', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canverifyuser") == true) {
            return true;
          } else {
            return false;
          }
        });

        Gate::define('blockip', function ($user) {
          $permission = new PermissionController;
          if ($permission->checkUserHasPermission($user, "canblockip") == true) {
            return true;
          } else {
            return false;
          }
        });
        //
    }
}
