<?php

namespace Source\Models;

use Source\Core\Model;


class ControlCalendario extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idControle", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "controlecalendario";

/** @var array $required table fileds */
protected static $required = [
 "FlagRealizouTutoria",
 "JustificativaTutoria"
];

public function bootstrap(
 string $FlagRealizouTutoria,
 string $JustificativaTutoria
): ?ControlCalendario {
$this->FlagRealizouTutoria = $FlagRealizouTutoria;
$this->JustificativaTutoria = $JustificativaTutoria;
return $this;
}

public function load(int $id, string $columns = "*"): ?ControlCalendario
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idControle = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Usuário não encontrado para o id informado";
return null;
}
return $load->fetchObject(__CLASS__);
}

public function joins(int $idTutor): ?array
{
$joins = $this->read("select cc.idControle,med.NomeMedico,med.email,med.fone_zap,
        ct.PeriodoInicial,ct.PeriodoFinal,
        cc.FlagRealizouTutoria,cc.JustificativaTutoria
        from medico med
        inner join controlecalendario cc on med.idMedico = cc.idMedico
        inner join calendariotutoria ct on cc.idCalendario = ct.idCalendario
        inner join vaga_tutoria vt on vt.idMedico = cc.idMedico
        where vt.idTutor={$idTutor};");
if ($this->fail() ||!$joins->rowCount()) {
$this->message = "Usuário não encontrado para o id informado";
return null;
}
return $joins->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

}
public function joinsBolsista(int $idBolsista): ?array
{
$joins = $this->read("select med.NomeMedico, ct.PeriodoInicial, ct.PeriodoFinal 
from medico med
inner join controlecalendario cc on med.idMedico = cc.idMedico
inner join calendariotutoria ct on cc.idCalendario = ct.idCalendario
inner join vaga_tutoria vt on vt.idMedico = cc.idMedico
where vt.idMedico ={$idBolsista};");
if ($this->fail() ||!$joins->rowCount()) {
$this->message = "Usuário não encontrado para o id informado";
return null;
}
return $joins->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

}
public function joinsEmailTutor(int $idBolsista): ?array
{
$joins = $this->read("select medico.email,medico.fone_zap from medico where medico.idMedico = "
        . "(SELECT vaga_tutoria.idTutor from vaga_tutoria "
        . "INNER JOIN medico_bolsista on vaga_tutoria.idMedico = medico_bolsista.idMedico "
        . "where medico_bolsista.idMedico = $idBolsista);");

if ($this->fail() ||!$joins->rowCount()) {
$this->message = "Usuário não encontrado para o id informado";
return null;
}
return $joins->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

}

public function find(string $terms, string $params, string $columns = "*"): ?ControlCalendario
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}


public function findById(int $id, string $columns = "*"): ?ControlCalendario
{
return $this->find("idControle = :id", "id={$id}", $columns);
}

/**
 * @param int $limit
 * @param int $offset
 * @param string $columns
 * @return array|null
 */
public function all(int $limit = 30, int $offset = 0, string $columns = "*"): ?array
{
$all = $this->read("SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset",
 "limit={$limit}&offset={$offset}");

if ($this->fail() ||!$all->rowCount()) {
return null;
}
return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
}

/**
 * @return: null|ControlCalendario
 */
public function save(): ?ControlCalendario
{
if (!$this->required()) {
$this->message->warning("Os dados são obrigatórios");
return null;
}

/** User Update */
if (!empty($this->id)) {
$userId = $this->id;

$this->update(self::$entity, $this->safe(), "idControle = :id", "id={$userId}");
if ($this->fail()) {
$this->message->error("Erro ao atualizar, verifique os dados");
return null;
}
}

/** User Create */
if (empty($this->id)) {

$userId = $this->create(self::$entity, $this->safe());
if ($this->fail()) {
$this->message->error("Erro ao cadastrar, verifique os dados");
return null;
}
}

$this->data = ($this->findById($userId))->data();
return $this;
}

public function Atualizar(string $params){
    //$userId = $this->id;
    $this->update(self::$entity, $this->safe(), "idControle = :id", "id={$params}");
    if ($this->fail()) {
    $this->message->error("Erro ao atualizar, verifique os dados");
    return null;
    }
}


/**
 * @return null|User
 */
public function destroy(): ?ControlCalendario
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idControle = :id", "id={$this->id}");
}

if ($this->fail()) {
$this->message = "Não foi possível remover o usuário";
return null;
}

$this->message = "Usuário removido com sucesso";
$this->data = null;
return $this;
}
}