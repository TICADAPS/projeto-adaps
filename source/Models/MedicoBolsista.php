<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class MedicoBolsista extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idMedico", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "medico_bolsista";

/** @var array $required table fileds */
protected static $required = ["nome_medico", "cpf_medico", "cod_uf"];

public function bootstrap(
 string $nome_medico,
 string $cpf_medico,
 int $cod_uf
): ?MedicoBolsista {
$this->nome_medico = $nome_medico;
$this->cpf_medico = $cpf_medico;
$this->cod_uf = $cod_uf;
return $this;
}

public function load(int $id, string $columns = "*"): ?MedicoBolsista
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idMedico = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Usuário não encontrado para o id informado";
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
public function find(string $terms, string $params, string $columns = "*"): ?MedicoBolsista
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
public function findById(int $id, string $columns = "*"): ?MedicoBolsista
{
return $this->find("idMedico = :id", "id={$id}", $columns);
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

public function remanejar(): ?array
{
$all = $this->read("SELECT md.idMedico,md.nome_medico,e.UF, mu.Municipio "
        . "FROM medico_bolsista md INNER JOIN estado e ON e.cod_uf = md.cod_uf "
        . "INNER JOIN medico m ON m.idMedico = md.idMedico "
        . "INNER JOIN municipio mu ON mu.cod_munc = m.Municipio_id "
        . "where md.idMedico not in (select idMedico from vaga_tutoria) ORDER BY e.UF;");

if ($this->fail() ||!$all->rowCount()) {
return null;
}
return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
}

/**
 * @return null|User
 */
public function save(): ?MedicoBolsista
{

/** User Update */
if (!empty($this->id)) {
$userId = $this->id;


$this->update(self::$entity, $this->safe(), "idMedico = :id", "id={$userId}");
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
public function destroy(): ?MedicoBolsista
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idMedico = :id", "id={$this->id}");
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