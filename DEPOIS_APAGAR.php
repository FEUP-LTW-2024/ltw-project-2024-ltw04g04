<?php
$passwords = ['passwordabc', 'password2', 'password3']; // Substitua estas senhas pelos valores reais que você deseja

foreach ($passwords as $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    echo "Senha: $password -> Hash: $hash\n";
}
?>