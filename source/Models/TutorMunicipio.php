<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class UserModel
 * @package Source\Models
 */
class TutorMunicipio extends Model
{
/** @var array $safe no update or create */
protected static $safe = ["idTutor", "created_at", "updated_at"];

/** @var string $entity database table */
protected static $entity = "tutor_municipio";

/** @var array $required table fileds */
protected static $required = [
    "idTutor",    
    "cod_munc",    
    "municipio",    
    "vaga_tutor",    
    "codUf"
    ];

public function bootstrap(
 int $idTutor,
 int $cod_munc,       
 string $municipio,
 int $vaga_tutor,
 int $codUf       
): ?TutorMunicipio {
$this->idTutor = $idTutor;
$this->cod_munc = $cod_munc;
$this->municipio = $municipio;
$this->vaga_tutor = $vaga_tutor;
$this->codUf = $codUf;
return $this;
}

public function load(int $id, string $columns = "*"): ?TutorMunicipio
{
$load = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE idTutor = :id", "id={$id}");
if ($this->fail() ||!$load->rowCount()) {
$this->message = "Tutor não encontrado para o id informado";
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
public function find(string $terms, string $params, string $columns = "*"): ?TutorMunicipio
{
$find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
if ($this->fail() ||!$find->rowCount()) {
return null;
}
return $find->fetchObject(__CLASS__);
}

public function selectMunicipio(int $codUf): ?array
{
    $joins = $this->read("select distinct mun.cod_munc, mun.Municipio from municipio "
            . "mun inner join tutor_municipio"
            . " tm on mun.cod_munc = tm.cod_munc where tm.codUf = $codUf order by mun.Municipio;");
    if ($this->fail() ||!$joins->rowCount()) {
    $this->message = "Usuário não encontrado para o id informado";
    return null;
}
    return $joins->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

}
public function selectTutor(): ?array
{
    $joins = $this->read("select tm.idTutor,md.NomeMedico from medico md inner join tutor_municipio tm on md.idMedico = tm.idTutor order by md.NomeMedico;");
    if ($this->fail() ||!$joins->rowCount()) {
    $this->message = "Usuário não encontrado";
    return null;
}
    return $joins->fetchAll(\PDO::FETCH_CLASS, __CLASS__);

}
/**
 * @param int $id
 * @param string $columns
 * @return null|User
 */
public function findById(int $id, string $columns = "*"): ?TutorMunicipio
{
return $this->find("idTutor = :id", "id={$id}", $columns);
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

public function Tutores(): ?array
{
$all = $this->read("SELECT idTutor,md.NomeMedico,UF,cod_munc,municipio,vaga_tutor as vaga 
FROM tutor_municipio tm  
    INNER JOIN medico md ON md.idMedico = tm.idTutor
    INNER JOIN estado e ON e.cod_uf = tm.codUf    
WHERE vaga_tutor > 0 ORDER BY UF");

if ($this->fail() ||!$all->rowCount()) {
return null;
}
return $all->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
}

/**
 * @return null|User
 */
public function save(): ?TutorMunicipio
{

/** User Update */
if (!empty($this->id)) {
$cod_munc = $this->id;

if ($this->find("municipio = :e AND cod_munc != :i", "e={$this->UF}&i={$cod_munc}")) {
$this->message->warning("O Estado informado já está cadastrado");
return null;
}

$this->update(self::$entity, $this->safe(), "cod_munc = :id", "id={$cod_munc}");
if ($this->fail()) {
$this->message->error("Erro ao atualizar, verifique os dados");
return null;
}
}

/** User Create */
if (empty($this->id)) {

$cod_munc = $this->create(self::$entity, $this->safe());
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
public function destroy(): ?TutorMunicipio
{
if (!empty($this->id)) {
$this->delete(self::$entity, "idTutor = :id", "id={$this->id}");
}

if ($this->fail()) {
$this->message = "Não foi possível remover o tutor";
return null;
}

$this->message = "tutor removido com sucesso";
$this->data = null;
return $this;
}
}