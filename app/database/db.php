<?php 

require('connect.php'); 



function dd($value) // to be deleted
{ 
    echo "<pre>", print_r($value, true), "</pre>"; 
    die();
}



function selectAll($table, $conditions = []) 
{ 
    global $conn; 
    $sql = "SELECT * FROM $table"; 
    if (empty($conditions)) {
    $stmt = $conn->prepare($sql); 
    $stmt->execute(); 
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
    return $records; 
} else { 
    $i = 0;
    foreach ($conditions as $key => $value){  
        if ($i === 0) { 
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
        

        } 
        
    $stmt = $conn->prepare($sql);  
    $values = array_values($conditions); 
    $types = str_repeat('s',count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute(); 
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 
    return $records; 

    
    }  

} 


function selectOne($table, $conditions) 
{ 
    global $conn; 
    $sql = "SELECT * FROM $table"; 
    
    $i = 0;
    foreach ($conditions as $key => $value){  
        if ($i === 0) { 
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    } 

    //$sql = "SELECT * FROM users WHERE admin=0 AND username='Awa' LIMIT1"
        
    $stmt = $conn->prepare($sql);  
    $values = array_values($conditions); 
    $types = str_repeat('s',count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute(); 
    $records = $stmt->get_result()->fetch_assoc(); 
    return $records; 

    
    

}


$conditions = [ 
'admin' => 0, 
'username' => 'Carter'
];

$users = selectOne('users', $conditions); 
dd($users);
