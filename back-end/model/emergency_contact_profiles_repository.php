<?php

/*  
 * Student Info: Name=Wei Jin, ID=9983
 * Subject: NPU_2016_Fall_CS556(A)_Team_Project
 * Author: Wei Jin 
 * Filename: emergency_contact_profiles_repository.php 
 * Date and Time: Nov 14, 2016 05:17:16 PM 
 * Project Name: CS556_Team_Project 
 */ 
class EmergencyContactProfilesRepository {
    // return all records as an array
    public static function getEmergencyContactProfiles() {
        global $db;
        $query = 'SELECT * FROM daycaredb.emergency_contact_profiles'
                . 'ORDER BY id'; //'OREDER
        $result = $db->query($query);
        $emergencyContactProfiles = array();
        foreach ($result as $row) {
            $emergencyContactProfile = new EmergencyContactProfiles($row['id'], $row['relationship'], $row['first_name'], 
                    $row['last_name'], $row['chinese_name'], $row['home_phone_number'], 
                    $row['occupation'], $row['work_time'], $row['work_phone_number'], $row['cell_phone_number'], $row['note']);
            $emergencyContactProfiles[] = $emergencyContactProfile;
        }
        return $emergencyContactProfiles;
    }
    // return one record by id, or NULL if no match
    public static function getEmergencyContactProfileById($id) {
        global $db;
        $query = "SELECT * FROM daycaredb.emergency_contact_profiles WHERE id = $id";
        $row_count = $db->exec($query);
        if($row_count == 0){
            return null;
        }
        $result = $db->query($query);
        $row = $result->fetch();
       $emergencyContactProfile = new EmergencyContactProfiles($row['id'], $row['relationship'], $row['first_name'], 
                    $row['last_name'], $row['chinese_name'], $row['home_phone_number'], 
                    $row['occupation'], $row['work_time'], $row['work_phone_number'], $row['cell_phone_number'], $row['note']);
        return $emergencyContactProfile;
    }
    // return all records match the child id, or NULL if no match
    public static function getEmergencyContactProfilesByChildId($childId) {
       global $db;
       $emergencyContactProfiles = array();
       $emergencyContactProfileid = array();
       $emergencyContactProfileid[0] = $childId->getEmer_1_id();
       $emergencyContactProfileid[1] = $childId->getEmer_2_id();
       for($i=0;$i<2;$i++){
       $query = "SELECT * FROM daycaredb.emergency_contact_profiles WHERE id = $emergencyContactProfileid[$i]";
       $row_count = $db->exec($query);
        if($row_count == 0){
            return null;
        }
        $result = $db->query($query);
        $row = $result->fetch();
        $emergencyContactProfile = new EmergencyContactProfiles($row['id'], $row['relationship'], $row['first_name'], 
                    $row['last_name'], $row['chinese_name'], $row['home_phone_number'], 
                    $row['occupation'], $row['work_time'], $row['work_phone_number'], $row['cell_phone_number'], $row['note']);
        $emergencyContactProfiles[] = $emergencyContactProfile;
        }
        return $emergencyContactProfiles;
    }
    
    // remove one record from DB, return 1 if record remove successed or 0 if failed
    public static function deleteEmergencyContactProfileById($id) {
        global $db;
        $query = "DELETE FROM daycaredb.emergency_contact_profiles WHERE id = $id";
        $row_count = $db->exec($query);   
        return $row_count;
    }
    // take a $signInRecord as parameter
    // insert into DB and return the "id" as integer which auto assign by the database
    // or return 0 if insert failed
    public static function addEmergencyContactProfile($emergencyContactProfile) {
        global $db;
        $id = $emergencyContactProfile->getId();
        $relationship = $emergencyContactProfile->getRelationship();
        $first_name = $emergencyContactProfile->getFirst_name();
        $last_name = $emergencyContactProfile->getlast_name();
        $chinese_name = $emergencyContactProfile->getChinese_name();
        $home_phone_number = $emergencyContactProfile->getHome_phone_number();
        $occupation = $emergencyContactProfile->getOccupation();
        $work_time = $emergencyContactProfile->getWork_time();
        $work_phone_number = $emergencyContactProfile->getWork_phone_number();
        $cell_phone_number = $emergencyContactProfile->getCell_phone_number();
        $note = $emergencyContactProfile->getNote();
        $query = "INSERT INTO daycaredb.emergency_contact_profiles (id, relationship, first_name, last_name, 
                chinese_name, home_phone_number, occupation, work_time, work_phone_number, cell_phone_number, note) 
                VALUES ($id, $relationship, $first_name, $last_name, 
                $chinese_name, $home_phone_number, $occupation, $work_time, $work_phone_number, $cell_phone_number, $note)";
        $db->exec($query);
        $query = "SELECT last_insert_id();";
        $emergencyContactProfileId = $db->exec($query);
        return $emergencyContactProfileId;
    }
}
