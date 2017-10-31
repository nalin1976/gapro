<?php

/**
 * @Nalin Channa Jayakody
 * @copyright 2016
 * HelaClothing MIS Department
 *  
 */

class Permission{

    private $dbConnection;
	
    public function SetConnection($connection){
            $this->dbConnection = $connection;
    }
    
    public function IsPermissionAllowed($prmUserId, $prmRoleName){
        
        $sql = " SELECT role.RoleName
                 FROM userpermission Inner Join role ON role.RoleID = userpermission.RoleID
                 WHERE userpermission.intUserID =  '$prmUserId' AND role.RoleName =  '$prmRoleName'";
        
        $resPermission = $this->dbConnection->RunQuery($sql);
        
        return $resPermission;
    }
    
}

?>
