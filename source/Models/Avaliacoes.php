<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Avaliacoes extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idAval", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "avaliacoes_medicos";

/** @var array $required table fileds */
protected static $required = [
 "idAval",
 "idMedico",
 "qntd_estrela",   
 "data_registro",   
 "cpfUser"
];

public function bootstrap(
 int $idAval,
 int $idMedico,
 int $qntd_estrela,
 string $data_registro,
 string $cpfUser 
): ?Avaliacoes {
$this->idAval = $idAval;
$this->idMedico = $idMedico;
$this->qntd_estrela = $qntd_estrela;
$this->data_registro = $data_registro;
$this->cpfUser = $cpfUser;
return $this;
}

public function load(int $id, string $columns = "*"): ?Avaliacoes
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idAval = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Avaliação não encontrado para o id informado";
return null;
}
return $load->fetchObject(__CLASS__);
}

/**
 * @param string $terms
 * @param string $params
 * @param string $columns
 * @return null|User
 */
public function find(string $terms, string $params, string $columns = "*"): ?Avaliacoes
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}


public function findById(int $id, string $columns = "*"): ?Avaliacoes
{
return $this->find("idAval = :id", "id={$id}", $columns);
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
 * @return null|User
 */
public function save(): ?Avaliacoes
{

/** User Update */
if (!empty($this->id)) {
$userId = $this->id;


$this->update(self::$entity, $this->safe(), "idAval = :id", "id={$userId}");
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

/**
 * @return null|User
 */
public function destroy(): ?Avaliacoes
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idAval = :id", "id={$this->id}");
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