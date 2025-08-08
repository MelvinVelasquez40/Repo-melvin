<?php

namespace Controllers\Medicamentos;

use Controllers\PublicController;
use Dao\Medicamentos\Medicamentos as DaoRecordatorio;
use Utilities\Validators;
use Utilities\Site;
use Views\Renderer;

class RecordatorioForm extends PublicController
{
    private $viewData = [];
    private $id = 0;
    private $nombre_usuario = "";
    private $edad = "";
    private $nombre_familiar = "";
    private $email_familiar = "";
    private $telefono_familiar = "";
    private $frecuencia_dosis = "";
    private $comentario = "";

    private $mode = "DSP";
    private $modeDscArr = [
        "DSP" => "Mostrar %s",
        "INS" => "Nuevo Recordatorio",
        "UPD" => "Editar %s",
        "DEL" => "Eliminar %s"
    ];

    private $error = [];
    private $has_errors = false;

    private function addError(string $msg, string $origin = "global")
    {
        if (!isset($this->error[$origin])) {
            $this->error[$origin] = [];
        }
        $this->error[$origin][] = $msg;
        $this->has_errors = true;
    }

    private function getGetData()
    {
        if (isset($_GET['mode'])) {
            $this->mode = $_GET['mode'];
            if (!isset($this->modeDscArr[$this->mode])) {
                $this->addError("Modo inválido");
            }
        }

        if (isset($_GET["id"])) {
            $this->id = intval($_GET["id"]);
            $recordatorio = DaoRecordatorio::getById($this->id);
            if ($recordatorio) {
                $this->nombre_usuario = $recordatorio["nombre_usuario"];
                $this->edad = $recordatorio["edad"];
                $this->nombre_familiar = $recordatorio["nombre_familiar"];
                $this->email_familiar = $recordatorio["email_familiar"];
                $this->telefono_familiar = $recordatorio["telefono_familiar"];
                $this->frecuencia_dosis = $recordatorio["frecuencia_dosis"];
                $this->comentario = $recordatorio["comentario"];
            } else {
                $this->addError("Recordatorio no encontrado");
            }
        }
    }

    private function getPostData()
    {
        $this->mode = $_POST["mode"] ?? $this->mode;

        $this->id = intval($_POST["id"] ?? 0);
        $this->nombre_usuario = trim($_POST["nombre_usuario"] ?? "");
        $this->edad = trim($_POST["edad"] ?? "");
        $this->nombre_familiar = trim($_POST["nombre_familiar"] ?? "");
        $this->email_familiar = trim($_POST["email_familiar"] ?? "");
        $this->telefono_familiar = trim($_POST["telefono_familiar"] ?? "");
        $this->frecuencia_dosis = trim($_POST["frecuencia_dosis"] ?? "");
        $this->comentario = trim($_POST["comentario"] ?? "");

        // Validaciones
        if (Validators::IsEmpty($this->nombre_usuario)) {
            $this->addError("El nombre del usuario es requerido.", "nombre_usuario_error");
        }

        if (Validators::IsEmpty($this->edad)) {
            $this->addError("La edad es requerida.", "edad_error");
        } elseif (!preg_match('/^\d+$/', $this->edad)) {
            $this->addError("La edad debe ser un número entero.", "edad_error");
        } else {
            $edadInt = intval($this->edad);
            if ($edadInt < 0 || $edadInt > 120) {
                $this->addError("La edad debe estar entre 0 y 120.", "edad_error");
            }
        }

        if (!Validators::IsEmpty($this->email_familiar) && !Validators::IsValidEmail($this->email_familiar)) {
            $this->addError("El email del familiar no tiene un formato válido.", "email_familiar_error");
        }

        if (!Validators::IsEmpty($this->telefono_familiar)) {
            if (!preg_match('/^\+?[0-9\s\-]{7,20}$/', $this->telefono_familiar)) {
                $this->addError("El teléfono del familiar no es válido.", "telefono_familiar_error");
            }
        }
    }

  private function executePostAction()
{
    switch ($this->mode) {
        case "INS":
            $result = DaoRecordatorio::add(
                $this->nombre_usuario,
                $this->edad,
                $this->nombre_familiar,
                $this->email_familiar,
                $this->telefono_familiar,
                $this->frecuencia_dosis,
                $this->comentario
            );
            if ($result > 0) {
                Site::redirectToWithMsg(
                    "index.php?page=Medicamentos_RecordatorioList",
                    "Recordatorio creado exitosamente."
                );
            } else {
                $this->addError("No se pudo crear el recordatorio.");
            }
            break;

        case "UPD":
            $result = DaoRecordatorio::update(
                $this->id,
                $this->nombre_usuario,
                $this->edad,
                $this->nombre_familiar,
                $this->email_familiar,
                $this->telefono_familiar,
                $this->frecuencia_dosis,
                $this->comentario
            );
            if ($result > 0) {
                Site::redirectToWithMsg(
                    "index.php?page=Medicamentos_RecordatorioForm&mode=DSP&id=" . $this->id,
                    "Recordatorio actualizado correctamente."
                );
            } else {
                $this->addError("Error al actualizar el recordatorio.");
            }
            break;

        case "DEL":
            $result = DaoRecordatorio::delete($this->id);
            if ($result > 0) {
                Site::redirectToWithMsg(
                    "index.php?page=Medicamentos_RecordatorioList",
                    "Recordatorio eliminado correctamente."
                );
            } else {
                $this->addError("Error al eliminar el recordatorio.");
            }
            break;
    }
}


    private function prepareView()
    {
        $this->viewData = [
            "modeDsc" => sprintf($this->modeDscArr[$this->mode], $this->nombre_usuario ?: ""),
            "mode" => $this->mode,
            "id" => $this->id,
            "nombre_usuario" => $this->nombre_usuario,
            "edad" => $this->edad,
            "nombre_familiar" => $this->nombre_familiar,
            "email_familiar" => $this->email_familiar,
            "telefono_familiar" => $this->telefono_familiar,
            "frecuencia_dosis" => $this->frecuencia_dosis,
            "comentario" => $this->comentario,
            "error" => $this->error,
            "has_errors" => $this->has_errors,
            "isReadOnly" => ($this->mode === "DSP" || $this->mode === "DEL") ? "readonly" : "",
            "showActions" => ($this->mode !== "DSP" && $this->mode !== "DEL"),
            "noActions" => ($this->mode === "INS")
        ];
    }

    public function run(): void
    {
        $this->getGetData();

        if ($this->isPostBack()) {
            $this->getPostData();

            if (!$this->has_errors) {
                $this->executePostAction();
            }
        }

        $this->prepareView();
        Renderer::render("medicamentos/form", $this->viewData);
    }
}
