<?php
interface ICrudData
{
    public function inserir(IGenericMainData $cliente);
    public function update(int $id, IGenericMainData $cliente);
    public function delete(int $id);
    public function read();
    public function readById(int $id);
}
?>