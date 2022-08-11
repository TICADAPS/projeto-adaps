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
protected static $safe = ["idVaga", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "vaga_tutoria";

/** @var array $required table fileds */
protected static $required = [
 "idVaga",
 "idMedico",
 "opcao1",   
 "opcao2",   
 "opcao3",   
 "opcao_escolhida",
 "idTutor",
 "munic_origem",
 "uf_origem",
 "munic_escolhido",
 "uf_escolhida",
 "distancia"
];

public function bootstrap(
 int $idMedico,
 int $opcao1,
 int $opcao2,
 int $opcao3,
 int $opcao_escolhida,
 int $idTutor,
 string $munOrigem,
 string $ufOrigem,
 string $munDestino,
 string $ufDestino,
 int $distancia
): ?VagaTutoria {
$this->idMedico = $idMedico;
$this->opcao1 = $opcao1;
$this->opcao2 = $opcao2;
$this->opcao3 = $opcao3;
$this->opcao_escolhida = $opcao_escolhida;
$this->idTutor = $idTutor;
$this->munic_origem = $munOrigem;
$this->uf_origem = $ufOrigem;
$this->munic_escolhido = $munDestino;
$this->uf_escolhida = $ufDestino;
$this->distancia = $distancia;
return $this;
}

public function load(int $id, string $columns = "*"): ?VagaTutoria
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idVaga = :id", "id={$id}");
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

public function bolsistas(int $idTutor): ?array
{
$all = $this->read("SELECT nome_medico from medico_bolsista mb 
INNER JOIN vaga_tutoria vt ON vt.idMedico = mb.idMedico
WHERE vt.idTutor = $idTutor; ");

if ($this->fail() ||!$all->rowCount()) {
return null;
}
return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
}

public function bolsistaComTutor(): ?array
{
$all = $this->read("SELECT DISTINCT vt.idMedico,md.NomeMedico, e.UF, mu.Municipio, 
opc.Municipio as opcaoEscolhia, et.UF as destino
    FROM vaga_tutoria vt
    INNER JOIN medico md ON vt.idMedico = md.idMedico
    INNER JOIN estado e ON e.cod_uf = md.Estado_idEstado                                   
    INNER JOIN municipio mu ON mu.cod_munc = md.Municipio_id
    INNER JOIN municipio opc on opc.cod_munc = vt.opcao_escolhida
    INNER JOIN tutor_municipio tm ON tm.cod_munc = opc.cod_munc
    INNER JOIN estado et on et.cod_uf = tm.codUf
ORDER BY md.NomeMedico;");

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

/** User Update */
if (!empty($this->id)) {
$userId = $this->id;


$this->update(self::$entity, $this->safe(), "idVaga = :id", "id={$userId}");
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
public function destroy(): ?VagaTutoria
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idVaga = :id", "id={$this->id}");
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