<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Municipio extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["cod_munc", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "municipio";

/** @var array $required table fileds */
protected static $required = [
    "cod_munc",    
    "Municipio",    
    "Estado_cod_uf"    
    ];

public function bootstrap(
 int $cod_munc,
 string $Municipio,
 int $cod_uf       
): ?Municipio {
$this->cod_munc = $cod_munc;
$this->Municipio = $Municipio;
$this->Estado_cod_uf = $cod_uf;
return $this;
}

public function load(int $id, string $columns = "*"): ?Municipio
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE cod_munc = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Municipio não encontrado para o id informado";
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
public function find(string $terms, string $params, string $columns = "*"): ?Municipio
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}

/**
 * @param int $id
 * @param string $columns
 * @return null|User
 */
public function findById(int $id, string $columns = "*"): ?Municipio
{
return $this->find("cod_munc = :id", "id={$id}", $columns);
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
public function save(): ?Municipio
{

/** User Update */
if (!empty($this->id)) {
$cod_munc = $this->id;

if ($this->find("Municipio = :e AND cod_munc != :i", "e={$this->Municipio}&i={$cod_munc}")) {
$this->message->warning("O Estado informado já está cadastrado");
return null;
}

$this->update(self::$entity, $this->safe(), "cod_uf = :id", "id={$cod_munc}");
if ($this->fail()) {
$this->message->error("Erro ao atualizar, verifique os dados");
return null;
}
}

/** User Create */
if (empty($this->id)) {

$cod_uf = $this->create(self::$entity, $this->safe());
if ($this->fail()) {
$this->message->error("Erro ao cadastrar, verifique os dados");
return null;
}
}

$this->data = ($this->findById($cod_munc))->data();
return $this;
}

/**
 * @return null|User
 */
public function destroy(): ?Municipio
{
if (!empty($this->id)) {
$this->delete(self::$entity, "cod_munc = :id", "id={$this->id}");
}

if ($this->fail()) {
$this->message = "Não foi possível remover o estado";
return null;
}

$this->message = "Estado removido com sucesso";
$this->data = null;
return $this;
}
}