<?php

namespace Controllers\Medicamentos;

use Controllers\PublicController;
use Dao\Medicamentos\Medicamentos;
use Views\Renderer;

class RecordatorioList extends PublicController
{
  public function run(): void
  {
    $viewData = [];

    // Obtener todos los recordatorios desde la base de datos
    $recordatorios = Medicamentos::getAll();
    $viewData["recordatorios"] = $recordatorios;

    var_dump($viewData["recordatorios"]); // <- Debes ver el array aquí

    // Renderizar la vista
    Renderer::render("medicamentos/list", $viewData);
  }
}
