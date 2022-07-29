<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Combustivel extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idcombustivel", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "combustivel";

/** @var array $required table fileds */
protected static $required = [
    "idcombustivel",    
    "valor",    
    "fator"    
    ];

public function bootstrap(
 float $valor,
 float $fator
 
): ?Combustivel {
$this->valor = $valor;
$this->fator = $fator;
return $this;
}

public function load(int $id, string $columns = "*"): ?Combustivel
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idcombustivel = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Combustivel não encontrado para o id informado";
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
public function find(string $terms, string $params, string $columns = "*"): ?Combustivel
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
public function findById(int $id, string $columns = "*"): ?Combustivel
{
return $this->find("idcombustivel = :id", "id={$id}", $columns);
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
public function save(): ?Combustivel
{

/** User Update */
if (!empty($this->id)) {
$cod_uf = $this->id;

if ($this->find("valor = :e AND fator != :i", "e={$this->UF}&i={$cod_uf}")) {
$this->message->warning("O Estado informado já está cadastrado");
return null;
}

$this->update(self::$entity, $this->safe(), "idcombustivel = :id", "id={$cod_uf}");
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
public function destroy(): ?Combustivel
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idcombustivel = :id", "id={$this->id}");
}

if ($this->fail()) {
$this->message = "Não foi possível remover o estado";
return null;
}

$this->message = "Combustível removido com sucesso";
$this->data = null;
return $this;
}
}