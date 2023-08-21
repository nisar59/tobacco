<?php

function AllPermissions()
{
    $role=[];
    $role['user']=['view','add','edit','delete'];
    $role['permissions']=['view','add','edit','delete'];
    $role['configuration']=['view','add','edit','delete'];
    $role['product']=['view','add','edit','delete'];
    $role['supplier']=['view','add','edit','delete'];
    $role['purchases']=['view','add','edit','delete','supplier','product'];
    $role['customer']=['view','add','edit','delete','export'];
    $role['sales']=['view','add','edit','delete','customer','product'];
    $role['cash']=['view','add','edit','delete'];
    $role['expense']=['view','add','edit','delete'];
    $role['reports']=['view','cash_flow'];
    return $role;

}