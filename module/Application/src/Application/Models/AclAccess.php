<?php

namespace Application\Models;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AclAccess extends Acl{

    const ADMIN_PANEL = 'admin_panel';
    const NEWS = 'news';
    const NEWS_PICTURES = 'news.pictures';

    //protected $acl;
    protected $roles = array('admin', 'manager', 'user');
    protected $resources = array(self::ADMIN_PANEL, self::NEWS, self::NEWS_PICTURES);

    public function __construct()
    {

        foreach($this->roles as $role){
            $this->addRole(new Role($role));
        }

        foreach($this->resources as $resource){
            $this->addResource(new Resource($resource));
        }

        $this->deny('user', self::ADMIN_PANEL);
        $this->deny('manager', self::ADMIN_PANEL);
        $this->deny('user', self::NEWS);

        $this->allow('admin', self::ADMIN_PANEL);
        $this->allow('admin', self::NEWS);
        $this->allow('admin', self::NEWS_PICTURES);

        $this->allow('manager', self::NEWS);
        $this->allow('manager', self::NEWS_PICTURES);

        $this->allow('user', self::NEWS_PICTURES);

    }

    public function getResourcesArray(){

        return $this->resources;

    }

    public function getRolesArray(){

        return $this->roles;

    }

}