<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class VagaTutoria extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["id", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "vaga_tutoria";

/** @var array $required table fileds */
protected static $required = [
 "idMedico",
 "opcao_escolhida",
 "idTutor"
];

public function bootstrap(
string $idMedico,
 string $opcao_escolhida,
 string $idTutor
): ?VagaTutoria {
$this->idMedico = $idMedico;
$this->opcao_escolhida = $opcao_escolhida;
$this->idTutor = $idTutor;
return $this;
}

public function load(int $id, string $columns = "*"): ?VagaTutoria
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
public function find(string $terms, string $params, string $columns = "*"): ?VagaTutoria
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}


public function findById(int $id, string $columns = "*"): ?VagaTutoria
{
return $this->find("idVaga = :id", "id={$id}", $columns);
}

/**
 * @param $email
 * @param string $columns
 * @return null|User
 */
public function findByEmail($email, string $columns = "*"): ?VagaTutoria
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
public function save(): ?VagaTutoria
{
if (!$this->required()) {
$this->message->warning("Nome, cpf, email e estado são obrigatórios");
return null;
}

if (!is_email($this->email)) {
$this->message->warning("O e-mail informado não tem um formato válido");
return null;
}

if (!is_passwd($this->password)) {
$min = CONF_PASSWD_MIN_LEN;
$max = CONF_PASSWD_MAX_LEN;
$this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
return null;
} else {
$this->password = passwd($this->password);
}

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
public function destroy(): ?VagaTutoria
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