<?php
interface ICrudData
{
    public function inserir(IGenericMainData $cliente);
    public function update(string $id, IGenericMainData $cliente);
    public function delete(string $id);
    public function read();
    public function readById(string $id);
}
?>