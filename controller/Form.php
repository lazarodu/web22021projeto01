<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["paciente"]) && isset($_POST["diag"]) && isset($_POST["idade"])) {
      try {
        $conexao = Transaction::get();
        $paciente = $conexao->quote($_POST["paciente"]);
        $diag = $conexao->quote($_POST["diag"]);
        $idade = $conexao->quote($_POST["idade"]);
        $crud = new Crud();
        $retorno = $crud->insert(
          "consultorio",
          "paciente,diag,idade",
          "{$paciente},{$diag},{$idade}"
        );
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
