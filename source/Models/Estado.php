<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Estado extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["cod_uf", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "estado";

/** @var array $required table fileds */
protected static $required = [
    "cod_uf",    
    "UF"    
    ];

public function bootstrap(
 string $UF
 
): ?Estado {
$this->UF = $UF;
return $this;
}

public function load(int $id, string $columns = "*"): ?Estado
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE cod_uf = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Estado não encontrado para o id informado";
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
public function find(string $terms, string $params, string $columns = "*"): ?Estado
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
public function findById(int $id, string $columns = "*"): ?Medico
{
return $this->find("cod_uf = :id", "id={$id}", $columns);
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
public function save(): ?Estado
{

/** User Update */
if (!empty($this->id)) {
$cod_uf = $this->id;

if ($this->find("UF = :e AND cod_uf != :i", "e={$this->UF}&i={$cod_uf}")) {
$this->message->warning("O Estado informado já está cadastrado");
return null;
}

$this->update(self::$entity, $this->safe(), "cod_uf = :id", "id={$cod_uf}");
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

$this->data = ($this->findById($cod_uf))->data();
return $this;
}

/**
 * @return null|User
 */
public function destroy(): ?Medico
{
if (!empty($this->id)) {
$this->delete(self::$entity, "cod_uf = :id", "id={$this->id}");
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