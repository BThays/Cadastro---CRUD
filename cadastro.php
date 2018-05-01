 <?php
    
    //CONEXÃO COM O BANCO DE DADOS

    //Estabelece a conexão com o banco de dados
   //local onde está instalado, usuário, senha)
  if($conexao = @mysql_connect('localhost', 'root', 'bcd127')){
        //Abilita o database a ser utilizado
        mysql_select_db('dbcontatos2018'); 
   }else{
       echo('ERRO: não foi possível conectar ao Banco de Dados, contate o Administrador ');
   }
    /*Se ocorrer um erro por conta da versão do xampp, deve-se utilizar a biblioteca do mysqli:
    $conexao = new mysqli('localhost', 'root', 'bcd127', 'dbcontato2018');*/

    //verifica o clique do botão
    if(isset($_GET['btnsalvar'])){ 
        
        //resgata os valores dos compos e armazena nas variáveis
        $nome = $_GET['txtnome'];
        $telefone = $_GET['txttelefone'];
        $celular = $_GET['txtcelular'];
        $email = $_GET['txtemail'];
        $dt_nasc = $_GET['txtdatanascimento'];
        
        /*Conversão da data digitada para o padrão americano
            Explode: pega a string digitada e quebra em um array de dados, utilizando um caracter coringa "/"
        */
        $dt = explode("/",$dt_nasc);
        
        //monta a data do padrão americano aceito pelo BD
        $dtnascimento = $dt[2]."-".$dt[1]."-".$dt[0];
        
        
        $sexo = $_GET['rdoopcao'];
        $obs = $_GET['txtobs'];
       
        //Inserir no banco de dados
       $sql = "insert into tbl_contatos (nome, telefone, celular, email, dt_nasc, sexo, obs) 
       values ('".$nome."', '".$telefone."', '".$celular."', '".$email."', '".$dtnascimento."', '".$sexo."', '".$obs."')";
    
        //salva os dados que estão na variavel ($sql) no BD
        mysql_query($sql);
        
        //redireciona para uma nova página
        header('location:cadastro.php');
    }

    //Programação para excluir ou editar um Registro
    if(isset($_GET['modo']))
    {
        $modo=$_GET['modo']; //Variavel vindo da URL
        if($modo == 'excluir')
        {
            $codigo = $_GET['id']; //Variavel LOCAL
            $sql="delete from tbl_contatos where idContato=".$codigo;
            mysql_query($sql);
            header('location:cadastro.php');
        }
    }

?>

<html>
    <head>
        <title>Cadastro de Contatos</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script> //SEMPRE use a tag script dentro do head
            //Chamar evento de QUALQUER elemento
            function validar(caracter, blocktype, campo) //Especificar function
            {   
                //Deixa a cor padrão branco quando o elemento campo for acionado
                //ao digitar os campos de forma errada (nome - apenasletras e telefone - apenas numeros)
                document.getElementById(campo).style="background-color:#ffffff;";
                
                //Tratamento para verificar de qual tipo de navegador
                //esta vindo a tecla
                
                if(window.event)
                    {
                        //Recebe a ascii do IE
                       var letra = caracter.charCode; 
                        
                        
                    
                    }else{
                        //Recebe a ascii dos outros navegadores
                        var letra = caracter.which;
                        
                    }
                 
                if(blocktype == 'caracter'){
            
                    //bloquear caracteres
                    if(letra < 48 || letra > 57){
                        if(letra!=8 && letra!=32){
                            //Troca a cor elemento conforme ele for bloqueado
                            //A variavel campo é recebida para funçao, nela contem
                            //o ID do elemento a ser formatado
                            document.getElementById(campo).style="background-color:#ad471f;";
                            return false; //cancela a ação
                            
                        } 
                    }
                }else if (blocktype == 'number'){

                    //bloquear numeros
                    if(letra >= 48 && letra <= 57){ // < ou > SEMPRE vem primeiro em algumas linguagens, tipo, javascript
                        if(letra!=8 && letra!=32){
                            
                            //Troca a cor elemento conforme ele for bloqueado
                            //A variavel campo é recebida para funçao, nela contem
                            //o ID do elemento a ser formatado
                            document.getElementById(campo).style="background-color:#ad471f;";
                            return false; //cancela a ação
                        } 
                 }
                }
            }
        </script>
        
    </head>
</html>

<body>
    <div id="caixa_principal">
            <!-- Operações/caracteristicas type input
                Elementos para o formulario do HTML5
                tel
                date
                month
                week
                email
                range
                number
                color
                url
                required - validação de caixas vazias
                password - proprio do html, oculta os caracteres na digitação Ex: senha
                -->
        <form name="frmcadastro" method="get" action="cadastro.php">
            <div id="titulo">
            </div>
            <div id="caixa_cadastro">
                <div id="titulo_cadastro">
                    Cadastro de Contatos
                </div>
              <div class="caixa_organizadora">
                    <div class="caixa">
                        Nome:
                    </div>
                    <div class="caixa_input">

                        <input id="nome" type="text" name="txtnome" size="10" value="" placeholder="Insira um nome" onkeypress="return validar(event, 'number','nome');">

                    </div>
                </div>
                 <div class="caixa_organizadora">
                    <div class="caixa">
                        Telefone:
                    </div>
                    <div class="caixa_input">

                        <input id="telefone" type="tel" name="txttelefone" size="10" value="" placeholder="" onkeypress="return validar(event, 'caracter','telefone');">

                    </div>
                </div>
                 <div class="caixa_organizadora">
                    <div class="caixa">
                        Celular:
                    </div>
                    <div class="caixa_input">
                        
                        <!-- Expressoes Regulares
                            pattern - deve ser utilizada na caixa para montar a expressão regular
                            Ex:
                            Permitir a digitação apenas de letras
                            pattern="[a-z A-Z ã Ã õ Õ é É ô Ô ê Ê ç Ç]*"

                            obs: não esquecer de especificar todas os caracteres que devem ser inseridos pelo usuario. Não esquecer de colcoar o * no final da expressão para permitir a digitação sequencial dos caracteres
                        -->
                        
                        <input type="tel" name="txtcelular" size="10"  value="" pattern="[0-9]{3} [0-9]{5}-[0-9]{4}" placeholder="Ex:011 99999-9999" title="Por favor, digite conforme o exemplo!" required>

                    </div>
                </div>
                 <div class="caixa_organizadora">
                    <div class="caixa">
                        Email:
                    </div>
                    <div class="caixa_input">

                        <input type="email" name="txtemail" size="10"  value="" placeholder="" required>

                    </div>
                </div>
                 <div class="caixa_organizadora">
                    <div class="caixa">
                        Data de
                        Nascimento:
                    </div>
                    <div class="caixa_input">

                        <input type="text" name="txtdatanascimento" size="10" maxlength="10" value="" placeholder="" required>

                    </div>
                </div>
                 <div class="caixa_organizadora">
                    <div class="caixa">
                        Sexo:
                    </div>
                    <div id="caixa_radio">
                            
                        
                             <input  type="radio" name="rdoopcao" value="F">Feminino
                         
                        
                             <input  type="radio" name="rdoopcao" value="M">Masculino
                         

                    </div>
                </div>
                <div id="caixa_organizadora_obs">
                    <div id="caixa_obs">
                        Obs:
                    </div>
                    <div id="caixa_escrita">

                        <textarea name="txtobs">
                        </textarea>

                    </div>
                </div>
                <div id="caixa_botoes">
                       <input type="submit" name="btnsalvar"  value="Salvar"  id="botao_input" required >
                    
                        <input type="submit" name="btnlimpar"  value="Limpar"  id="botao_input">
                </div>
               
            </div>
             <div  id="caixa_adiciona">
                <div id="titulo_adiciona">
                    Consulta de Contatos
                 </div>
                 <div id="div_table">
                     <div id="linha">
                         <div class="coluna">
                             Nome
                         </div>
                         <div class="coluna">
                             Telefone
                         </div>
                         <div class="coluna">
                             Celular
                         </div>
                         <div class="coluna">
                             E-mail
                         </div>
                         <div class="coluna">
                             Opções
                         </div>
                     </div>
                   
                      <?php
                            $sql="select * from tbl_contatos order by idContato desc";
                     
                            $resultado = mysql_query($sql);
                            
                            //Os dois comandos abaixo permitem converter
                            //o resultado do BD em um array de dados
                     
                            // mysql_fetch_array
                            // mysql_fetch_assoc
                     
                            $contador=0;       
                     
                            while($rsContatos=mysql_fetch_array($resultado)) //Rs -> nomenclatura de RecordSet
                            { 
                                
                                if($contador%2==0)
                                    $cor="grey";
                                else
                                    $cor="#1e3838";
                           
                        ?>
                      <div style="background-color:<?php echo ($cor) ?>;" class="linha">
                         <div class="coluna">
                             <?php echo($rsContatos['nome']) ?>
                         </div>
                         <div class="coluna">
                             <?php echo($rsContatos['telefone']) ?>
                         </div>
                         <div class="coluna">
                             <?php echo($rsContatos['celular']) ?>
                         </div>
                         <div class="coluna">
                             <?php echo($rsContatos['email']) ?>
                         </div>
                         <div class="coluna">
                             <a>
                                 <img class="imagem" src="imagens/edit.png">
                             </a>
                             
                            <a href="cadastro.php?modo=excluir&id=<?php echo($rsContatos['idContato']) ?>" onclick=" return confirm('Deseja realmente Excluir o registro?')">
                                <img class="imagem"src="imagens/delete.png">
                            </a>
                         </div>
                     </div>
                     <?php 
                            $contador+=1;
                            }
                     ?>
                 </div>
            </div>
        </form>
    </div>
</body>