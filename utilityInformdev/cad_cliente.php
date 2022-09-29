<?php
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}

 $erro = false;

if(count($_POST) > 0){

    include('conexao.php');
   
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nascimento = $_POST['nascimento'];
    $telefone = $_POST['telefone'];

    if(strlen($nome) < 3 || strlen($email) < 5 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        $erro =  "Ops! esta faltando algo.";
    }

    if(!empty($nascimento)){
        $pedacoes = explode('/', $nascimento);
        if(count($pedacoes) == 3){
        $nascimento = implode ('-',array_reverse($pedacoes));
        }else {
            $erro = "Ops! Siga o exemplo.";
        }
    }

    if(!empty($telefone)){
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11){
            $erro = "Ops! algo não está certo.";
        }
    }

    if($erro){
        $erro;
    }else{
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data)
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
        $roling = $mysqli->query($sql_code) or die($mysqli->error);
        if($roling){
            $erro = "Cadastro realizado com sucesso.";
            unset($_POST);
        }
    }
         
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,300&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <section class="wrapper">
        <div class="login-container">
            <h1>Ficha de cadastro</h1>
            <h2><?= $erro ?></h2>
            <form method="POST" action="">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" 
                    value ="<?php if(isset($_POST['nome']))echo $_POST['nome']; ?>"
                    placeholder="Digite seu nome completo">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email"
                    value ="<?php if(isset($_POST['email']))echo $_POST['email']; ?>" 
                    placeholder="Digite seu email">
                </div>
                <div>
                    <label >Data de Nascimento:</label>
                    <input type="text" name="nascimento" id="nascimento"
                    value ="<?php if(isset($_POST['nascimento']))echo $_POST['nascimento']; ?>" 
                    placeholder="Dia/Mes/Ano Exemplo: 31/12/2022">
                </div>
                <div>
                    <label >Telefone</label>
                    <input type="text" name="telefone" id="telefone"
                    value ="<?php if(isset($_POST['telefone']))echo $_POST['telefone']; ?>" 
                    placeholder="(12)98888-8888">
                </div>
                <div class="submit">
                <label >Oi confira seus dados antes de clicar no botão obrigado pela atenção!</label>
                    <input type="submit" value="Cadastrar">
                </div>
            </form>
            <div class="register">
                <a href="">Voltar</a>
            </div>
        </div>                             
    </section>
</body>
</html>
