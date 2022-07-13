<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class Medico extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idMedico", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "medico";

/** @var array $required table fileds */
protected static $required = [
    "NomeMedico", 
    "CpfMedico", 
    "fone_zap", 
    "email",
    "Convocacao",
    "Judicial",
    "Estado_idEstado",
    "idCargo",
    "Municipio_id"
    ];

public function bootstrap(
 string $NomeMedico,
 string $CpfMedico,
 string $fone_zap,
 string $email,
 string $Convocacao,
 string $Judicial,
 string $Estado_idEstado,
 string $idCargo,
 string $Municipio_id
): ?Medico {
$this->NomeMedico = $NomeMedico;
$this->CpfMedico = $CpfMedico;
$this->fone_zap = $fone_zap;
$this->email = $email;
$this->Convocacao = $Convocacao;
$this->Judicial = $Judicial;
$this->Estado_idEstado = $Estado_idEstado;
$this->idCargo = $idCargo;
$this->Municipio_id = $Municipio_id;
return $this;
}

public function load(int $id, string $columns = "*"): ?Medico
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
public function find(string $terms, string $params, string $columns = "*"): ?Medico
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
return $this->find("idMedico = :id", "id={$id}", $columns);
}

/**
 * @param $email
 * @param string $columns
 * @return null|User
 */
public function findByEmail($email, string $columns = "*"): ?Medico
{
return $this->find("email = :email", "email={$email}", $columns);
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
public function save(): ?Medico
{
if (!$this->required()) {
$this->message->warning("Nome, cpf, email e estado são obrigatórios");
return null;
}

if (!is_email($this->email)) {
$this->message->warning("O e-mail informado não tem um formato válido");
return null;
}

//if (!is_passwd($this->password)) {
//$min = CONF_PASSWD_MIN_LEN;
//$max = CONF_PASSWD_MAX_LEN;
//$this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
//return null;
//} else {
//$this->password = passwd($this->password);
//}

/** User Update */
if (!empty($this->id)) {
$userId = $this->id;

if ($this->find("email = :e AND id != :i", "e={$this->email}&i={$userId}")) {
$this->message->warning("O e-mail informado já está cadastrado");
return null;
}

$this->update(self::$entity, $this->safe(), "idMedico = :id", "id={$userId}");
if ($this->fail()) {
$this->message->error("Erro ao atualizar, verifique os dados");
return null;
}
}

/** User Create */
if (empty($this->id)) {
if ($this->findByEmail($this->email)) {
$this->message->warning("O e-mail informado já está cadastrado");
return null;
}

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
public function destroy(): ?Medico
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