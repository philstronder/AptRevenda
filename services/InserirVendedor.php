<?php
    include 'connSettings.php';
    
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $dataAtual = date('y-m-d h:m:s');
    
    $nome = $_POST["Nome"];
    $telefone = $_POST["Telefone"];
    $uf = $_POST["UF"];
    $municipio = $_POST["Municipio"];
	$email = $_POST["Email"];
	$CodigoRevenda = rand_string(6);
    $cpf = RetirarMascaraCPF($_POST["CPF"]);


	$stmt = $conn->prepare("INSERT INTO Vendedor (Nome, Email, Telefone, UF, Municipio, CodigoRevenda, CPF) VALUES (?,?,?,?,?,?,?)");

	$stmt->bind_param("sssssss", $nome, $email, $telefone, $uf, $municipio, $CodigoRevenda, $cpf);

	$stmt->execute();
	
	echo "New record created successfully";
	
	$stmt->close();
	$conn->close();



function RetirarMascaraCPF($cpf){
    $cpfSomenteNumeros = str_replace(".","",$cpf);
    $cpfSomenteNumeros = str_replace("-","",$cpfSomenteNumeros);
    return $cpfSomenteNumeros;
}

function rand_string($length) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	return substr(str_shuffle($chars),0,$length);
}
	


?>