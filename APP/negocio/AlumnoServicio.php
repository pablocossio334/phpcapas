<?php
require_once "AlumnoDAO.php";

class AlumnoServicio {

    public function listarAlumnos() {
        return AlumnoDAO::obtenerAlumnos();
    }

}