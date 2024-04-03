<?php 

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../model/justificativa.php');
include_once(__DIR__ . '/../DAO/DaoJustificativa.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){    

    $idUsuario = $_POST['idUsuario']; 
    $idLocal = $_POST['local'];       
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $justificativaTexto = $_POST['justificativa']; // Renomeie para evitar conflito de nomes
    $evidencia = $_FILES['evidencia']; // Usamos $_FILES para obter a imagem

    $dataHora = (new DateTime($data." ".$hora))->format("Y-m-d H:i:s");   
    
    $justificativa = new Justificativa(null, $idUsuario, $idLocal, $justificativaTexto, $dataHora, null);

    if($justificativa != null && $evidencia['error'] == 0){ // Verifica se não houve erro no upload da imagem

        // Define o diretório de destino da imagem
        $diretorioDestino = __DIR__ . '/../public/img/evidenciaJust/';

        // Define o novo nome do arquivo (opcional, depende de como você quer nomear os arquivos)
        $novoNomeArquivo = uniqid() . '_' . $evidencia['name']; // Pode ser um nome único para evitar duplicatas

        // Move o arquivo para o diretório de destino
        if(move_uploaded_file($evidencia['tmp_name'], $diretorioDestino . $novoNomeArquivo)){           

            // Define o caminho da imagem no servidor
            $caminhoImagemServidor = $diretorioDestino . $novoNomeArquivo;

            // Define o atributo evidencia da justificativa como o caminho da imagem
            $justificativa->setEvidencia($caminhoImagemServidor);

            // Insere a justificativa no banco de dados junto com o caminho da imagem
            $conexao = new Conexao();
            $daoJustificativa = new DaoJustificativa($conexao->conectar(), $idUsuario);       
            $idJustificativa = $daoJustificativa->inserirJustificativa($justificativa);

            if($idJustificativa > 0){
                header("Location: ../cliente/index2.php?addJust=1");
            } else {
                header("Location: ../cliente/index2.php?addJust=0");
            }

        } else {
            header("Location: ../cliente/index2.php?addJust=0&erro=upload");
        }

    } else {
        header("Location: ../cliente/index2.php?addJust=0&erro=imagem");
    }   

}

?>
